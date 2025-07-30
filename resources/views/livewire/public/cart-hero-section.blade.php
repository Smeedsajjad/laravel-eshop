<div>
    @php
    $steps = [
    1 => ['label' => 'Shopping&nbsp;Cart', 'route' => 'cart'],
    2 => ['label' => 'Checkout', 'route' => 'checkout'],
    3 => ['label' => 'Order&nbsp;Complete', 'route' => 'order.complete'],
    ];
    @endphp

    <nav class="flex flex-col sm:flex-row justify-around items-center
            text-white bg-purple-700 p-6 sm:p-8 md:p-12 lg:p-16 rounded-xl gap-4 sm:gap-2">
        @foreach($steps as $idx => $data)
        <div class="flex items-center gap-2">
            <span class="hidden sm:inline text-purple-300">{{ $idx }}.</span>
            <a href="{{ route($data['route']) }}" wire:navigate class="text-xl sm:text-2xl font-semibold
                      {{ $step === $idx ? 'underline underline-offset-8' : '' }}">
                {!! $data['label'] !!}
            </a>
        </div>

        @if(!$loop->last)
        <x-heroicon-s-arrow-long-right class="hidden sm:inline size-4 text-purple-200" />
        @endif
        @endforeach
    </nav>
</div>
