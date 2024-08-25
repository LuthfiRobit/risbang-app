    <style>
        .icon-facebook {
            color: #4267B2;
        }

        /* Facebook blue */
        .icon-instagram {
            color: #E1306C;
        }

        /* Instagram pink */
        .icon-github {
            color: #333;
        }

        /* GitHub black */
        .icon-whatsapp {
            color: #25D366;
        }

        /* WhatsApp green */
        .icon-gmail {
            color: #D93025;
        }

        /* Gmail red */
        .icon-linkedin {
            color: #0077B5;
        }

        /* LinkedIn blue */
        .icon-twitter {
            color: #1DA1F2;
        }

        /* Twitter blue */
    </style>
    <style>
        /* Styling untuk spinner loading */
        .spinner-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 8px solid rgba(0, 0, 0, 0.1);
            border-left-color: #007bff;
            /* Warna spinner */
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
