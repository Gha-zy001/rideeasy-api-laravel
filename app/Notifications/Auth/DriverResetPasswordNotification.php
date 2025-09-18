<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DriverResetPasswordNotification extends Notification
{
  use Queueable;
  protected string $otp;

  public function __construct(string $otp)
  {
      $this->otp = $otp;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): MailMessage
  {
    return (new MailMessage)
    ->subject(__('Your Driver Password Reset OTP'))
    ->greeting(__('Hello :name', ['name' => $notifiable->name]))
    ->line(__('Use the following OTP to reset your password:'))
    ->line("**{$this->otp}**")
    ->line(__('This OTP will expire in :count minutes.', ['count' => 10]))
    ->line(__('If you did not request a password reset, ignore this email.'));
}
    
  

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      //
    ];
  }
}
