@if (session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-1000"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg text-center"
    >
        {{ session('success') }}
    </div>
@endif