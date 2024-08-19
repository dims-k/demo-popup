document.addEventListener('DOMContentLoaded', function() {
    const root = document.documentElement;
    root.style.setProperty('--dpp-link-button-color', dpp_settings.link_button_color);
    root.style.setProperty('--dpp-link-button-text-color', dpp_settings.link_button_text_color);
    root.style.setProperty('--dpp-link-button-hover-color', dpp_settings.link_button_hover_color);
    root.style.setProperty('--dpp-modal-button-color', dpp_settings.modal_button_color);
    root.style.setProperty('--dpp-modal-button-text-color', dpp_settings.modal_button_text_color);
    root.style.setProperty('--dpp-modal-button-hover-color', dpp_settings.modal_button_hover_color);
    console.log('CSS Variables set:', getComputedStyle(root).getPropertyValue('--dpp-modal-button-hover-color'));

    document.querySelectorAll('.play-button').forEach(button => {
        button.addEventListener('click', function() {
            console.log('Play button clicked');

            var modalDemo = this.closest('.popup-demo');
            if (!modalDemo) {
                console.error('Element with class .popup-demo not found');
                return;
            }
            var modalId = modalDemo.getAttribute('data-popup-id');
            var modal = document.getElementById('popup-' + modalId);
            if (!modal) {
                console.error('Element with id popup-' + modalId + ' not found');
                return;
            }
            var iframe = modal.querySelector('.popup-iframe');
            if (!iframe) {
                console.error('Element with class .popup-iframe not found');
                return;
            }
            iframe.src = this.getAttribute('data-demo-link');
            modal.style.display = 'flex';

            console.log('Modal opened, checking for overlay settings');

            // Check if overlay is enabled
            var overlayEnabled = modalDemo.getAttribute('data-overlay-enabled');
            if (overlayEnabled !== '1') {
                return;
            }

            // Get overlay settings
            var overlayTime = parseInt(modalDemo.getAttribute('data-overlay-time')) || 30;
            var overlayButtonText = modalDemo.getAttribute('data-overlay-button-text');
            var overlayButtonColor = modalDemo.getAttribute('data-overlay-button-color');
            var overlayButtonTextColor = modalDemo.getAttribute('data-overlay-button-text-color');
            var overlayButtonHoverColor = modalDemo.getAttribute('data-overlay-button-hover-color');
            var overlayButtonHoverTextColor = modalDemo.getAttribute('data-overlay-button-hover-text-color');
            var overlayButtonLink = modalDemo.getAttribute('data-overlay-button-link');
            var overlayContinueButtonText = modalDemo.getAttribute('data-overlay-continue-button-text');
            var overlayContinueButtonColor = modalDemo.getAttribute('data-overlay-continue-button-color');
            var overlayContinueButtonTextColor = modalDemo.getAttribute('data-overlay-continue-button-text-color');
            var overlayContinueButtonHoverColor = modalDemo.getAttribute('data-overlay-continue-button-hover-color');
            var overlayContinueButtonHoverTextColor = modalDemo.getAttribute('data-overlay-continue-button-hover-text-color');
            var yandexMetrikaCounter = dpp_settings.yandex_metrika_counter;

            console.log('Overlay settings:', {
                overlayTime,
                overlayButtonText,
                overlayButtonColor,
                overlayButtonTextColor,
                overlayButtonHoverColor,
                overlayButtonHoverTextColor,
                overlayButtonLink,
                overlayContinueButtonText,
                overlayContinueButtonColor,
                overlayContinueButtonTextColor,
                overlayContinueButtonHoverColor,
                overlayContinueButtonHoverTextColor
            });

            // Remove existing overlay if present
            const existingOverlay = modal.querySelector('#game-overlay');
            if (existingOverlay) {
                existingOverlay.remove();
            }

            // Set a timer to add the overlay after the specified time
            setTimeout(() => {
                console.log(`${overlayTime} seconds passed, adding overlay`);

                const overlay = document.createElement('div');
                overlay.id = 'game-overlay';
                overlay.style.display = 'flex';
                overlay.innerHTML = `
<div class="container-p">
    <a href="${modalDemo.getAttribute('data-casino1-link')}" class="block-link" onclick="ym(${yandexMetrikaCounter}, 'reachGoal', 'casino1-${modalId}'); return true;">
        <div class="block-p" style="background-color: ${modalDemo.getAttribute('data-card-background-color')}">
            <img src="${modalDemo.getAttribute('data-casino1-logo')}" alt="${modalDemo.getAttribute('data-casino1-name')} Logo">
            <div class="title-p">${modalDemo.getAttribute('data-casino1-name')}</div>
            <div class="bonus-p" style="color: ${modalDemo.getAttribute('data-bonus-text-color')}">${modalDemo.getAttribute('data-casino1-bonus')}</div>
            <div class="play-button-p" style="background-color: ${modalDemo.getAttribute('data-button-color')};">${modalDemo.getAttribute('data-casino1-button-text')}</div>
        </div>
    </a>
    <a href="${modalDemo.getAttribute('data-casino2-link')}" class="block-link" onclick="ym(${yandexMetrikaCounter}, 'reachGoal', 'casino1-${modalId}'); return true;">
        <div class="block-p" style="background-color: ${modalDemo.getAttribute('data-card-background-color')}">
            <img src="${modalDemo.getAttribute('data-casino2-logo')}" alt="${modalDemo.getAttribute('data-casino2-name')} Logo">
            <div class="title-p">${modalDemo.getAttribute('data-casino2-name')}</div>
            <div class="bonus-p" style="color: ${modalDemo.getAttribute('data-bonus-text-color')}">${modalDemo.getAttribute('data-casino2-bonus')}</div>
            <div class="play-button-p" style="background-color: ${modalDemo.getAttribute('data-button-color')};">${modalDemo.getAttribute('data-casino2-button-text')}</div>
        </div>
    </a>
</div>
<button id="ocb" class="ocb"
        style="color: ${overlayContinueButtonTextColor}; background: ${overlayContinueButtonColor};"
        onclick="ym(${yandexMetrikaCounter}, 'reachGoal', 'ocb-${modalId}'); return true;">
        ${overlayContinueButtonText}
</button>`;
                modal.appendChild(overlay);

                const overlayContinueButton = document.getElementById('ocb');

                overlayContinueButton.addEventListener('click', function() {
                    overlay.style.display = 'none';
                    console.log('Overlay continue button clicked');
                });

                overlayContinueButton.addEventListener('mouseover', function() {
                    overlayContinueButton.style.color = overlayContinueButtonHoverTextColor;
                    overlayContinueButton.style.background = overlayContinueButtonHoverColor;
                });

                overlayContinueButton.addEventListener('mouseout', function() {
                    overlayContinueButton.style.color = overlayContinueButtonTextColor;
                    overlayContinueButton.style.background = overlayContinueButtonColor;
                });
            }, overlayTime * 1000); // Convert seconds to milliseconds
        });
    });

    document.querySelectorAll('.link-button').forEach(button => {
        button.addEventListener('click', function() {
            var casinoLink = this.getAttribute('data-casino-link');
            if (casinoLink) {
                window.open(casinoLink, '_blank');
            }
        });
    });

    document.querySelectorAll('.reload-iframe').forEach(button => {
        button.addEventListener('click', function() {
            var modal = this.closest('.popup');
            if (!modal) {
                console.error('Element with class .popup not found');
                return;
            }
            var iframe = modal.querySelector('.popup-iframe');
            if (!iframe) {
                console.error('Element with class .popup-iframe not found');
                return;
            }
            var currentSrc = iframe.src;
            iframe.src = '';
            iframe.src = currentSrc;
        });
    });

    document.querySelectorAll('.close-popup').forEach(button => {
        button.addEventListener('click', function() {
            var modal = this.closest('.popup');
            if (!modal) {
                console.error('Element with class .popup not found');
                return;
            }
            var iframe = modal.querySelector('.popup-iframe');
            if (iframe) {
                iframe.src = '';
            }
            modal.style.display = 'none';

            // Remove overlay when modal is closed
            const overlay = modal.querySelector('#game-overlay');
            if (overlay) {
                overlay.remove();
            }
        });
    });

    // Apply popup background color
    document.querySelectorAll('.popup-content').forEach(content => {
        content.style.backgroundColor = dpp_settings.modal_color;
    });
});
