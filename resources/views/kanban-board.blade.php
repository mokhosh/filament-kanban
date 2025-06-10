<x-filament-panels::page class="{{ isset($showKanban) && $showKanban == false ? 'hidden' : '' }}">
    <div x-data="kanbanBoardComponent({
        livewireId: @js($this->getId()),
    })">
        @if ((isset($enableSearch) && $enableSearch) || (isset($enableFilter) && $enableFilter))
            <div class="flex justify-end gap-8 items-center">
                @if ($enableSearch ?? false)
                    {{-- <x-filament-tables::search-field @input.debounce="search" /> --}}
                    <x-filament::input.wrapper>
                        <x-filament::input type="text" @input.debounce="search"
                            placeholder="{{ __('webshops.search') }}" />
                    </x-filament::input.wrapper>
                @endif

                @if ($enableFilter ?? false)
                    <x-filament::dropdown placement="bottom-start" width="sm">
                        <x-slot name="trigger">
                            <x-filament::icon-button icon="heroicon-o-funnel"
                                badge="{{ isset($filtersBadgeCount) && $filtersBadgeCount > 0 ? $filtersBadgeCount : '' }}" />
                        </x-slot>

                        <x-filament-panels::form class="font-normal p-4" wire:submit.prevent="onFilter">
                            {{ $this->filtersForm }}

                            <x-filament::button class="w-full -mt-2" type="submit" wire:loading.attr="disabled"
                                wire:target="onFilter">
                                {{ __('general.apply') }}
                            </x-filament::button>
                        </x-filament-panels::form>
                    </x-filament::dropdown>
                @endif
            </div>
        @endif

        <div wire:ignore class="relative md:flex overflow-x-auto overflow-y-hidden gap-2 pb-4 min-h-[66.5vh] h-full">

            <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-opacity-75 z-50  ">
                <x-filament::loading-indicator class="h-8 w-8" />


            </div>
            <template x-for="status in statuses" :key="status.id">
                @include(static::$statusView)
            </template>

        </div>

        @unless ($disableEditModal)
            @if (isset($this->recordDeletable) && $this->recordDeletable)
                @include('filament.app.widgets.kanban-edit-record-modal')
            @else
                <x-filament-kanban::edit-record-modal />
            @endif
        @endunless
    </div>
    <script>
        function kanbanBoardComponent({
            livewireId
        }) {
            return {
                statuses: [],
                async search(e) {
                    this.loading = true
                    const statuses = await this.$wire.search(e.target.value)
                    this.statuses = statuses
                    this.loading = false
                },
                init() {
                    document.addEventListener('statusesUpdated', (e) => {
                        this.statuses = e.detail[0].statuses

                        this.$nextTick(() => {
                            this.initSortable()
                        })
                    })

                    document.addEventListener('updateStatusFromTo', (e) => {
                        const {
                            recordId,
                            fromStatus,
                            toStatus
                        } = e.detail[0]

                        this.handleStatusChange(recordId, fromStatus, toStatus)
                    })

                    this.loading = true

                    this.$wire.statuses().then(statuses => {
                        this.statuses = statuses
                        this.loading = false
                        this.$nextTick(() => this.initSortable())
                    })


                },
                handleStatusChange(recordId, fromStatus, toStatus) {
                    const record = this.statuses.find(status => status.id == fromStatus).records.find(record =>
                        record.id == recordId)
                    if (!record) return

                    const fromContainer = this.statuses.find(status => status.id == fromStatus)
                    if (fromContainer) {
                        fromContainer.records = fromContainer.records.filter(r => r.id !== recordId)
                    }

                    console.log(this.statuses)
                    const toContainer = this.statuses.find(status => status.id == toStatus)
                    console.log(toContainer, toStatus)
                    if (toContainer) {
                        console.log(toContainer, record)
                        toContainer.records.push(record)
                    }
                },
                initSortable() {
                    const self = this
                    this.statuses.forEach(status => {
                        const el = document.querySelector(`[data-status-id='${status.id}']`)
                        if (!el) return

                        Sortable.create(el, {
                            group: 'filament-kanban',
                            ghostClass: 'opacity-50',
                            animation: 0,
                            onStart() {
                                document.body.classList.add("grabbing")
                            },
                            onEnd() {
                                document.body.classList.remove("grabbing")
                            },
                            onAdd(e) {
                                const recordId = e.item.id
                                const status = e.to.dataset.statusId
                                const fromOrderedIds = Array.from(e.from.children).map(c => c.id).filter(
                                    id =>
                                    id)
                                const toOrderedIds = Array.from(e.to.children).map(c => c.id).filter(id =>
                                    id)
                                self.$wire.statusChanged(recordId, status,
                                    fromOrderedIds, toOrderedIds)
                            },
                            onUpdate(e) {
                                const recordId = e.item.id
                                const status = e.from.dataset.statusId
                                const orderedIds = Array.from(e.from.children).map(c => c.id).filter(id =>
                                    id)
                                self.$wire.sortChanged(recordId, status, orderedIds)
                            },
                            setData(dataTransfer, el) {
                                dataTransfer.setData('id', el.id)
                            },
                        })
                    })
                }
            }
        }
    </script>
</x-filament-panels::page>
