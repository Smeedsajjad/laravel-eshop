<?php

namespace App\Livewire\Public;

use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{
    #[Layout('layouts.app')]

    public string $name    = '';
    public string $email   = '';
    public string $subject = '';
    public string $message = '';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        Mail::to(config('mail.from.address'))
            ->queue(new ContactFormSubmitted(
                name: $this->name,
                email: $this->email,
                subject: $this->subject,
                body: $this->message,
            ));

        session()->flash('message', 'Thank you! Your message has been sent.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.public.contact');
    }
}
