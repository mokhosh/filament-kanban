<div class="flex flex-col flex-shrink-0 w-72">
    <div class="flex items-center flex-shrink-0 h-10 justify-between">

        <div class="flex items-center">
            <span class="block text-sm font-semibold mr-2" x-text="status.title"></span>

            <span class="inline-flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-1.5 min-w-[theme(spacing.5)] py-0.5 tracking-tight"
                x-bind:class="{
                    'bg-gray-50 text-gray-600 ring-gray-600/10 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20': status.badgeColor === 'gray',
                    'fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30': status.badgeColor !== 'gray'
                }"
                x-bind:style="status.badgeColor !== 'gray' ? {
                    '--c-50': 'var(--' + status.badgeColor + '-50)',
                    '--c-400': 'var(--' + status.badgeColor + '-400)', 
                    '--c-600': 'var(--' + status.badgeColor + '-600)'
                } : {}">
                <span x-text="status.records.length"></span>
            </span>
        </div>

        <template x-if="status.totalAttribute">
            <span class="block text-sm font-normal"
                x-text="status.records.reduce((acc, record) => acc + parseFloat(record[status.totalAttribute]), 0).toLocaleString('nl-NL', { style: 'currency', currency: 'EUR' })">
            </span>
        </template>
    </div>
</div>
