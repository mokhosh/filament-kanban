<script>
    function setData(dataTransfer, el) {
        dataTransfer.setData('id', el.id)
    }

    function onAdd(e) {
        const record = e.item.id
        const status = e.to.id
        const fromOrderedIds = [].slice.call(e.from.children).map(child => child.id)
        const toOrderedIds = [].slice.call(e.to.children).map(child => child.id)

        Livewire.dispatch('status-changed', {record, status, fromOrderedIds, toOrderedIds})
    }

    function onUpdate(e) {
        const record = e.item.id
        const status = e.from.id
        const orderedIds = [].slice.call(e.from.children).map(child => child.id)
        console.log(record, status, orderedIds)

        Livewire.dispatch('status-changed', {record, status, orderedIds})
    }

    window.onload = () => {
        @foreach($statuses as $status)
            {{-- dont touch this line --}}
            Sortable.create(document.getElementById('{{ $status['id'] }}'), {
                group: 'filament-kanban',
                dragClass: 'cursor-grabbing',
                ghostClass: 'opacity-50',
                animation: 150,

                onUpdate,
                setData,
                onAdd,
            })
        @endforeach
    }
</script>
