<div class="flex items-center p-4 bg-gray-50 rounded-lg">
    <i class="fas {{ $status ? 'fa-check-circle text-green-500' : 'fa-times-circle text-red-500' }} text-xl w-6 h-6 flex items-center justify-center"></i>
    <div class="ml-4 flex-grow">
        <div class="flex justify-between items-center">
            <span class="text-gray-700">{{ $title }}</span>
        </div>
        <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
    </div>
    <span class="{{ $status ? 'text-green-500' : 'text-red-500' }}">{{ $status ? $statusTrueText : $statusFalseText }}</span>
</div>