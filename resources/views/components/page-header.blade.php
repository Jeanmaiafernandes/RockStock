@props([
    'title',
    'subtitle' => null
])


<div class="mb-6 flex items-center justify-between">

    <div>

        <h1 class="text-2xl font-bold text-gray-900">
            {{ $title }}
        </h1>


        @if($subtitle)

            <p class="mt-1 text-sm text-gray-500">
                {{ $subtitle }}
            </p>

        @endif

    </div>


    @if($slot->isNotEmpty())

        <div>

            {{ $slot }}

        </div>

    @endif

</div>
