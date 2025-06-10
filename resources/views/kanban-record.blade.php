<div :id="record.id" wire:click="recordClicked(record.id, [])" :key="record.id"
    class="record bg-white dark:bg-gray-700 rounded-lg px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200">
    <span x-text="record.title"></span>
</div>
