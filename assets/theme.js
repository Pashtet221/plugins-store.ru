(() => {
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
        } else if (event.target.closest('[data-nav-anchor]')) {
            event.target.closest('dialog')?.close();
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
                card.style.setProperty('--catalog-left', (index % 3) * 408 + 'px');
                card.style.setProperty('--catalog-top', 59 + Math.floor(index / 3) * 371 + 'px');
            });
            container.querySelectorAll('button[data-filter]').forEach((button) =>
                button.setAttribute('aria-pressed', String(button.dataset.filter === selected)));
            const count = container.querySelector('[data-count]');
            if (count) count.textContent = 'Найдено: ' + shown.length;
            if (option.dataset.jump) container.querySelector('[data-grid]')?.scrollIntoView();
        }
    });

    const brandToggle = document.querySelector('.brand-motion-toggle');
    brandToggle?.addEventListener('click', () => {
        const paused = brandToggle.getAttribute('aria-pressed') !== 'true';
        brandToggle.setAttribute('aria-pressed', String(paused));
        document.getElementById('home-brand-track').toggleAttribute('data-paused', paused);
    });

    const slides = document.getElementById('home-catalog-cards');
    if (slides) {
        const previous = document.querySelector('[data-slide="-1"]');
        const next = document.querySelector('[data-slide="1"]');
        const updateControls = () => {
            previous.disabled = slides.scrollLeft <= 1;
            next.disabled = slides.scrollLeft + slides.clientWidth >= slides.scrollWidth - 1;
        };
        [previous, next].forEach((button) => button.addEventListener('click', () => {
            const [first, second] = slides.children;
            const step = second.offsetLeft - first.offsetLeft;
            const behavior = matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth';
            slides.scrollBy({ left: Number(button.dataset.slide) * step, behavior });
        }));
        slides.addEventListener('scroll', updateControls, { passive: true });
        new ResizeObserver(updateControls).observe(slides);
        updateControls();
    }

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
