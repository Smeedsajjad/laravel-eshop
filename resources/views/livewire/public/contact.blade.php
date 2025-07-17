<div>
    <h1 class="text-4xl text-center text-black font-bold">Contact Us</h1>

    <div class="flex flex-col md:flex-row gap-16 p-4 text-gray-950">
        <div class="flex-1 text-white rounded-xl text-center">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58712.12373967853!2d73.37940316446203!3d31.339188502344367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39227f1ccf7f02a7%3A0x28c6d11859d7ff15!2sJaranwala%2C%20Pakistan!5e1!3m2!1sen!2s!4v1752595449318!5m2!1sen!2s"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="flex-1">
            <form wire:submit.prevent="submit" class="space-y-4">
                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="label">
                        <span class="label-text text-gray-900">Name</span>
                    </label>
                    <input type="text" wire:model="name" placeholder="Your Name" required
                        class="input input-bordered w-full bg-white border border-gray-500 focus:border-purple-700 {{ $errors->has('name') ? 'border-error' : '' }}" />
                </div>
                <div>
                    <label class="label">
                        <span class="label-text text-gray-900">Email</span>
                    </label>
                    <input type="email" wire:model="email" placeholder="you@example.com" required
                        class="input input-bordered w-full bg-white border border-gray-500 focus:border-purple-700 {{ $errors->has('email') ? 'border-error' : '' }}" />
                </div>
                <div>
                    <label class="label">
                        <span class="label-text text-gray-900">Subject</span>
                    </label>
                    <input type="text" wire:model="subject" placeholder="Subject"
                        class="input input-bordered w-full bg-white border border-gray-500 focus:border-purple-700 {{ $errors->has('subject') ? 'border-error' : '' }}" />
                </div>
                <div>
                    <label class="label">
                        <span class="label-text text-gray-900">Message</span>
                    </label>
                    <textarea wire:model="message" placeholder="Your message..." required
                        class="textarea textarea-bordered w-full h-32 bg-white border border-gray-500 focus:border-purple-700 {{ $errors->has('message') ? 'border-error' : '' }}"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn border-0 bg-purple-600 w-full">Send Message</button>
                </div>
            </form>

            @if (session('message'))
                <div class="alert alert-success mt-4">{{ session('message') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error mt-4">{{ session('error') }}</div>
            @endif

            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
        </div>
    </div>

</div>
