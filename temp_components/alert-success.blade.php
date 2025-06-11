@if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show" 
        x-transition 
        x-cloak 
        class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-6 py-3 rounded shadow-md z-50 shadow-lg text-sm font-medium"
        style="z-index: 9999;"
    >
        {{ session('success') }}
    </div>
@endif
