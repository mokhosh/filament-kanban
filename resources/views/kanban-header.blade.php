<div class="flex flex-col flex-shrink-0 w-72">
    <div class="flex items-center flex-shrink-0 h-10 justify-between">

        <div class="flex items-center">
            <span class="block text-sm font-semibold mr-2" x-text="status.title"></span>


            <x-filament::badge size="sm" x-bind:color="status.badgeColor">
                <span x-text="status.records.length"></span>
            </x-filament::badge>
        </div>

        <template x-if="status.totalAttribute">
            <span class="block text-sm font-normal"
                x-text="status.records.reduce((acc, record) => acc + parseFloat(record[status.totalAttribute]), 0).toLocaleString('nl-NL', { style: 'currency', currency: 'EUR' })">
            </span>
        </template>
    </div>
</div>
