(() => {
    const mobile = matchMedia('(max-width: 760px)');
    const homeCatalog = document.getElementById('n-240-91');
    const covers = homeCatalog ? [...homeCatalog.children]
        .filter((item) => item.classList.contains('image-layer') && item.previousElementSibling)
        .map((item) => ({ item, card: item.previousElementSibling })) : [];
    const placeCovers = () => covers.forEach(({ item, card }) => {
        if (mobile.matches) {
            item.classList.add('mobile-card-cover');
            card.prepend(item);
        } else {
            item.classList.remove('mobile-card-cover');
            card.after(item);
        }
    });
    mobile.addEventListener('change', placeCovers);
    placeCovers();

    const show = (name) => {
        const dialog = document.getElementById('overlay-' + name);
        if (!dialog) return;
        document.querySelectorAll('dialog[open]').forEach((item) => {
            if (item !== dialog) item.close();
        });
        if (!dialog.open) dialog.showModal();
    };

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-open], [data-close]');
        if (trigger) {
            event.preventDefault();
            if (trigger.hasAttribute('data-close')) trigger.closest('dialog')?.close();
            else show(trigger.dataset.open);
        } else if (event.target.matches('dialog')) {
            event.target.close();
        }

        const copy = event.target.closest('[data-copy-key][data-key]');
        if (copy && navigator.clipboard) {
            navigator.clipboard.writeText(copy.dataset.key).then(() => {
                copy.querySelector('.text').textContent = 'Ключ скопирован';
            }).catch(() => {});
        }
        const option = event.target.closest('[data-filter]');
        if (option) {
            const container = option.closest('.scene');
            const selected = option.dataset.filter;
            const cards = [...container.querySelectorAll('[data-category]')];
            cards.forEach((card) => {
                card.hidden = selected !== 'Все' && card.dataset.category !== selected;
            });
            const shown = cards.filter((card) => !card.hidden);
            shown.forEach((card, index) => {
                card.style.left = (index % 3) * 408 + 'px';
                card.style.top = 59 + Math.floor(index / 3) * 371 + 'px';
            });
            container.querySelectorAll('button[data-filter]').forEach((button) =>
                button.setAttribute('aria-pressed', String(button.dataset.filter === selected)));
            const count = container.querySelector('[data-count]');
            if (count) count.textContent = 'Найдено: ' + shown.length;
            if (option.dataset.jump) container.querySelector('[data-grid]')?.scrollIntoView();
        }
    });

    const initialFilter = new URLSearchParams(location.search).get('filter');
    if (initialFilter) {
        [...document.querySelectorAll('button[data-filter]')]
            .find((item) => item.dataset.filter === initialFilter)?.click();
    }
    document.querySelectorAll('.attachment input').forEach((input) => {
        input.addEventListener('change', () => {
            const label = input.closest('.attachment').querySelector('.text');
            if (label) label.textContent = input.files[0]?.name || 'Прикрепить файл';
        });
    });
})();
