<x-layout>
    <x-slot:heading>
        Job Detail
    </x-slot:heading>

    <h2 class="font-bold">{{ $job['title'] }}</h2>
    <p>This job pays {{ $job['salary'] }} per year</p>
</x-layout>
