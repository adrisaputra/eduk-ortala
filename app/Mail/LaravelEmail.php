<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LaravelEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from('parau.project@gmail.com')
        //            ->view('admin.send_email.index')
        //            ->with(
        //             [
        //                 'nama' => 'Diki Alfarabi Hadi',
        //                 'website' => 'www.malasngoding.com',
        //             ]);

        return $this->from('parau.project@gmail.com')
                    ->subject($this->data['subject'])
                    ->view('admin.send_email.message')
                    ->with('data', $this->data);
    }
}
