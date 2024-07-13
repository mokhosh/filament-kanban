<script>
    function onStart() {
        setTimeout(() => document.body.classList.add("grabbing"))
    }

    function onEnd() {
        document.body.classList.remove("grabbing")
    }

    function setData(dataTransfer, el) {
        dataTransfer.setData('id', el.id)
    }

    function onAdd(e) {
        const recordId = e.item.id
        const status = e.to.dataset.statusId
        const fromOrderedIds = [].slice.call(e.from.children).map(child => child.id)
        const toOrderedIds = [].slice.call(e.to.children).map(child => child.id)

        Livewire.dispatch('status-changed', {recordId, status, fromOrderedIds, toOrderedIds})
    }

    function onUpdate(e) {
        const recordId = e.item.id
        const status = e.from.dataset.statusId
        const orderedIds = [].slice.call(e.from.children).map(child => child.id)

        Livewire.dispatch('sort-changed', {recordId, status, orderedIds})
    }

    document.addEventListener('livewire:navigated', () => {
        const statuses = @js($statuses->map(fn ($status) => $status['id']));
    
        statuses.forEach(status => {
            const element = document.querySelector(`[data-status-id='${status}']`);
            const sortableInstance = Sortable.create(element, {
                group: 'filament-kanban',
                ghostClass: 'opacity-50',
                animation: 150,
                onStart(event) {
                    // Disable dragging initially
                    sortableInstance.option('disabled', true);
    
                    // Re-enable dragging after 2 seconds
                    setTimeout(() => {
                        sortableInstance.option('disabled', false);
                    }, 1000);
    
                    // Call your original onStart function if needed
                    if (typeof onStart === 'function') {
                        onStart(event);
                    }
                },
                onEnd,
                onUpdate,
                setData,
                onAdd,
            });
        });
    });
</script>
