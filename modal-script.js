document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.play-button').forEach(button => {
        button.addEventListener('click', function() {
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
        });
    });

    document.querySelectorAll('.link-button').forEach(button => {
        button.addEventListener('click', function() {
            var casinoLink = this.getAttribute('data-casino-link');
            if (casinoLink) {
                window.location.href = casinoLink;
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
        });
    });

    // Apply popup background color
    document.querySelectorAll('.popup-content').forEach(content => {
        content.style.backgroundColor = dpp_settings.modal_color;
    });

    // Apply button colors
    const root = document.documentElement;
    root.style.setProperty('--dpp-link-button-color', dpp_settings.link_button_color);
    root.style.setProperty('--dpp-link-button-text-color', dpp_settings.link_button_text_color);
    root.style.setProperty('--dpp-link-button-hover-color', dpp_settings.link_button_hover_color);
    root.style.setProperty('--dpp-modal-button-color', dpp_settings.modal_button_color);
    root.style.setProperty('--dpp-modal-button-text-color', dpp_settings.modal_button_text_color);
    root.style.setProperty('--dpp-modal-button-hover-color', dpp_settings.modal_button_hover_color);
});