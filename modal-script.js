document.addEventListener('DOMContentLoaded', function () {
    const root = document.documentElement;
    root.style.setProperty('--dpp-link-button-color', dpp_settings.link_button_color);
    root.style.setProperty('--dpp-link-button-text-color', dpp_settings.link_button_text_color);
    root.style.setProperty('--dpp-link-button-hover-color', dpp_settings.link_button_hover_color);
    root.style.setProperty('--dpp-modal-button-color', dpp_settings.modal_button_color);
    root.style.setProperty('--dpp-modal-button-text-color', dpp_settings.modal_button_text_color);
    root.style.setProperty('--dpp-modal-button-hover-color', dpp_settings.modal_button_hover_color);

    const yandexMetrikaCounter = dpp_settings.yandex_metrika_counter;

    document.querySelectorAll('.play-button').forEach(button => {
        button.addEventListener('click', function () {
            const modalDemo = this.closest('.popup-demo');
            if (!modalDemo) {
                console.error('Element with class .popup-demo not found');
                return;
            }

            const modalId = modalDemo.getAttribute('data-popup-id');
            const modal = document.getElementById('popup-' + modalId);
            if (!modal) {
                console.error('Element with id popup-' + modalId + ' not found');
                return;
            }

            const iframe = modal.querySelector('.popup-iframe');
            if (!iframe) {
                console.error('Element with class .popup-iframe not found');
                return;
            }

            iframe.src = this.getAttribute('data-demo-link');
            modal.style.display = 'flex';

            const overlayEnabled = modalDemo.getAttribute('data-overlay-enabled');
            if (overlayEnabled !== '1') {
                return;
            }

            const overlayTime = parseInt(modalDemo.getAttribute('data-overlay-time')) || 30;

            let overlayTimeout;

            function addOverlay() {
                if (modal.style.display === 'none') {
                    console.log("Modal closed, not showing overlay.");
                    return;
                }

                console.log("Adding overlay...");

                const overlay = document.createElement('div');
                overlay.id = 'game-overlay';
                overlay.style.display = 'flex';
                overlay.innerHTML = `
<div class="container-p">
    <a href="${modalDemo.getAttribute('data-casino1-link')}" class="block-link" target="_blank" onclick="ym(${yandexMetrikaCounter}, 'reachGoal', 'opb-${modalId}'); return true;">
        <div class="block-p" style="background-color: ${modalDemo.getAttribute('data-card-background-color')}">
            <img src="${modalDemo.getAttribute('data-casino1-logo')}" alt="${modalDemo.getAttribute('data-casino1-name')} Logo">
            <div class="title-p">${modalDemo.getAttribute('data-casino1-name')}</div>
            <div class="bonus-p" style="color: ${modalDemo.getAttribute('data-bonus-text-color')}">${modalDemo.getAttribute('data-casino1-bonus')}</div>
            <div class="play-button-p" style="background-color: ${modalDemo.getAttribute('data-button-color')};">${modalDemo.getAttribute('data-casino1-button-text')}</div>
        </div>
    </a>
    <a href="${modalDemo.getAttribute('data-casino2-link')}" class="block-link" target="_blank" onclick="ym(${yandexMetrikaCounter}, 'reachGoal', 'opb2-${modalId}'); return true;">
        <div class="block-p" style="background-color: ${modalDemo.getAttribute('data-card-background-color')}">
            <img src="${modalDemo.getAttribute('data-casino2-logo')}" alt="${modalDemo.getAttribute('data-casino2-name')} Logo">
            <div class="title-p">${modalDemo.getAttribute('data-casino2-name')}</div>
            <div class="bonus-p" style="color: ${modalDemo.getAttribute('data-bonus-text-color')}">${modalDemo.getAttribute('data-casino2-bonus')}</div>
            <div class="play-button-p" style="background-color: ${modalDemo.getAttribute('data-button-color')};">${modalDemo.getAttribute('data-casino2-button-text')}</div>
        </div>
    </a>
</div>
<button id="ocb" class="ocb"
        style="color: ${modalDemo.getAttribute('data-overlay-continue-button-text-color')}; background: ${modalDemo.getAttribute('data-overlay-continue-button-color')};"
        onclick="ym(${yandexMetrikaCounter}, 'reachGoal', 'ocb-${modalId}'); return true;">
        ${modalDemo.getAttribute('data-overlay-continue-button-text')}
</button>`;
                modal.appendChild(overlay);

                const overlayContinueButton = document.getElementById('ocb');

                overlayContinueButton.addEventListener('click', function () {
                    overlay.style.display = 'none';

                    clearTimeout(overlayTimeout);

                    overlayTimeout = setTimeout(() => {
                        modal.removeChild(overlay);
                        addOverlay();
                    }, overlayTime * 1000);
                });

                overlayContinueButton.addEventListener('mouseover', function () {
                    overlayContinueButton.style.color = modalDemo.getAttribute('data-overlay-continue-button-hover-text-color');
                    overlayContinueButton.style.background = modalDemo.getAttribute('data-overlay-continue-button-hover-color');
                });

                overlayContinueButton.addEventListener('mouseout', function () {
                    overlayContinueButton.style.color = modalDemo.getAttribute('data-overlay-continue-button-text-color');
                    overlayContinueButton.style.background = modalDemo.getAttribute('data-overlay-continue-button-color');
                });
            }

            overlayTimeout = setTimeout(() => {
                console.log(`Showing overlay after ${overlayTime} seconds`);
                addOverlay();
            }, overlayTime * 1000);

            modal.querySelector('.close-popup').addEventListener('click', function () {
                clearTimeout(overlayTimeout);
                const existingOverlay = modal.querySelector('#game-overlay');
                if (existingOverlay) {
                    existingOverlay.remove();
                }
            });
        });
    });

    document.querySelectorAll('.link-button').forEach(button => {
        button.addEventListener('click', function () {
            const casinoLink = this.getAttribute('data-casino-link');
            if (casinoLink) {
                window.open(casinoLink, '_blank');
            }
        });
    });

    document.querySelectorAll('.reload-iframe').forEach(button => {
        button.addEventListener('click', function () {
            const modal = this.closest('.popup');
            if (!modal) {
                console.error('Element with class .popup not found');
                return;
            }
            const iframe = modal.querySelector('.popup-iframe');
            if (!iframe) {
                console.error('Element with class .popup-iframe not found');
                return;
            }
            const currentSrc = iframe.src;
            iframe.src = '';
            iframe.src = currentSrc;
        });
    });

    document.querySelectorAll('.close-popup').forEach(button => {
        button.addEventListener('click', function () {
            const modal = this.closest('.popup');
            if (!modal) {
                console.error('Element with class .popup not found');
                return;
            }
            const iframe = modal.querySelector('.popup-iframe');
            if (iframe) {
                iframe.src = '';
            }
            modal.style.display = 'none';

            const overlay = modal.querySelector('#game-overlay');
            if (overlay) {
                overlay.remove();
            }
        });
    });

    document.querySelectorAll('.popup-content').forEach(content => {
        content.style.backgroundColor = dpp_settings.modal_color;
    });
});