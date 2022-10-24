<?php

namespace App\Http\Controllers;

use App\Payments as P;
use App\Correspondence as C;
use DB;
use Mail;
use App\Mail\OrderInvoice;
use Illuminate\Http\Request;

class CronController extends Controller
{

    public function RemindersCronJob(){
        $data = P::selectRaw('id, (SELECT email from users where id = (SELECT employee_id from orders where id = payment_settings.order_id)) as employee_email, (SELECT company_name from customers where id = (SELECT customer_id from orders where id = payment_settings.order_id)) as customer, due_date, DATE(NOW()), days_before_deadline, DATEDIFF(due_date, DATE(NOW())) as days_difference')->whereRaw('DATEDIFF(due_date, DATE(NOW())) = days_before_deadline OR DATEDIFF(due_date, DATE(NOW())) = 0 and id NOT IN (SELECT payment_id from reminders_sent)')->get()->toArray();
        foreach($data as $value){
            Mail::to($value['employee_email'])->send(new OrderInvoice(["message" => "Payment scheduled for Customer: ".$value['customer']." reaching it's deadline in ".$value['days_difference']." day(s) as the deadline is: ".$value['due_date'], "subject" => "Payment Reminder"]));
            DB::table('reminders_sent')->insert([
                'payment_id' => $value['id']
            ]);
        }

        $correspondences = C::selectRaw('id, title, mom, due_date, due_time, (SELECT email from users where id = correspondences.created_by) as employee_email')->whereRaw('type = "task" and id NOT IN (SELECT correspondence_id from follow_up_reminders_sent) and reminder_date = DATE(NOW()) and TIME(reminder_time) <= TIME(NOW())')->get()->toArray();

        foreach($correspondences as $value){
            Mail::to($value['employee_email'])->send(new OrderInvoice(["message" => "You scheduled this time as a follow up to your task which is as follows: <br><br>  <strong>Title:</strong> ".$value['title'].'<br> <strong>Due Date:</strong> '.$value['due_date'].'<br> <strong>Due Time:</strong> '.date('h:m A', strtotime($value['due_time'])).' <br> <strong>Description:</strong> <p>'.$value['mom'].'</p>', "subject" => "Task Reminder"]));
            DB::table('follow_up_reminders_sent')->insert([
                'correspondence_id' => $value['id']
            ]);
        }

        echo "All Crons Executed";
    }

    public function GitPull(Request $request){
        \SSH::into('production')->run(array(
            'cd /var/www/import-export.sell3sixty.com',
            'git pull origin master',
        ));
    }

}
