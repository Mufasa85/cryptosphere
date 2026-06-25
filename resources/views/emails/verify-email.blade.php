{{-- resources/views/emails/verify-email.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Email - MicroCredit</title>
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            background-color: #050B12;
            color: #E9F2F7;
            padding: 40px 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Conteneur principal */
        .container {
            max-width: 560px;
            width: 100%;
            margin: 0 auto;
            background-color: #0D1823;
            border-radius: 16px;
            border: 1px solid #142634;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        }

        /* En-tête */
        .header {
            background: linear-gradient(135deg, #0D1823 0%, #07131B 100%);
            padding: 40px 40px 30px;
            text-align: center;
            border-bottom: 1px solid #142634;
        }

        .header .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: #00C45A;
            border-radius: 50%;
            margin-bottom: 16px;
        }

        .header .logo span {
            font-size: 28px;
            font-weight: 800;
            color: #050B12;
            letter-spacing: -1px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #E9F2F7;
            margin-bottom: 8px;
        }

        .header p {
            color: #AEBBC6;
            font-size: 14px;
        }

        /* Corps du message */
        .content {
            padding: 40px;
            background-color: #0D1823;
        }

        .content .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #E9F2F7;
            margin-bottom: 12px;
        }

        .content .message {
            color: #AEBBC6;
            font-size: 15px;
            margin-bottom: 8px;
            line-height: 1.8;
        }

        .content .message strong {
            color: #E9F2F7;
        }

        /* Call to Action */
        .cta-container {
            background-color: #07131B;
            border-radius: 12px;
            padding: 30px;
            margin: 24px 0;
            text-align: center;
            border: 1px solid #142634;
        }

        .cta-container .btn {
            display: inline-block;
            background-color: #00C45A;
            color: #050B12;
            padding: 14px 40px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0, 196, 90, 0.25);
        }

        .cta-container .btn:hover {
            background-color: #3DFF7A;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(0, 196, 90, 0.4);
        }

        .cta-container .btn:active {
            transform: translateY(0);
        }

        .cta-container .btn-secondary {
            display: inline-block;
            color: #AEBBC6;
            font-size: 13px;
            margin-top: 12px;
            word-break: break-all;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .cta-container .btn-secondary:hover {
            color: #E9F2F7;
        }

        /* Infos supplémentaires */
        .info-box {
            background-color: #07131B;
            border-left: 3px solid #00C45A;
            padding: 16px 20px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .info-box p {
            color: #AEBBC6;
            font-size: 13px;
            line-height: 1.6;
        }

        .info-box .icon {
            color: #00C45A;
            margin-right: 8px;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #142634;
            margin: 24px 0;
        }

        /* Footer */
        .footer {
            padding: 30px 40px;
            background-color: #07131B;
            border-top: 1px solid #142634;
            text-align: center;
        }

        .footer p {
            color: #AEBBC6;
            font-size: 12px;
            line-height: 1.8;
        }

        .footer .copyright {
            color: #142634;
            font-size: 11px;
            margin-top: 8px;
        }

        .footer .social-links {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin: 16px 0 12px;
        }

        .footer .social-links a {
            color: #AEBBC6;
            text-decoration: none;
            font-size: 12px;
            transition: color 0.3s ease;
        }

        .footer .social-links a:hover {
            color: #00C45A;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .header {
                padding: 30px 20px 24px;
            }

            .header h1 {
                font-size: 20px;
            }

            .content {
                padding: 24px 20px;
            }

            .cta-container {
                padding: 20px;
            }

            .cta-container .btn {
                padding: 12px 28px;
                font-size: 14px;
                width: 100%;
            }

            .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <div class="logo">
                <span>MC</span>
            </div>
            <h1>Vérification d'Email</h1>
            <p>Activez votre compte en un clic</p>
        </div>

        <!-- Corps -->
        <div class="content">
            <p class="greeting">Bonjour {{ $userName ?? 'Utilisateur' }},</p>

            <p class="message">
                Merci d'avoir créé un compte sur <strong>{{ $appName ?? 'MicroCredit' }}</strong>.
                Pour finaliser votre inscription et activer votre compte, veuillez vérifier votre adresse email.
            </p>

            <div class="cta-container">
                <a href="{{ $verificationUrl ?? '#' }}" class="btn">
                     Vérifier mon adresse email
                </a>
                <br>
                <a href="{{ $verificationUrl ?? '#' }}" class="btn-secondary">
                    Copier le lien si le bouton ne fonctionne pas
                </a>
            </div>

            <div class="info-box">
                <p>
                    <span class="icon"></span>
                    Ce lien est valable <strong>24 heures</strong>.
                    Si vous n'avez pas créé de compte, ignorez cet email.
                </p>
            </div>

            <hr class="divider">

            <p class="message" style="font-size: 13px; color: #AEBBC6; margin-top: 8px;">
                Besoin d'aide ? Contactez notre support à
                <a href="mailto:support@microcredit.com" style="color: #00C45A; text-decoration: none;">
                    support@microcredit.com
                </a>
            </p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">LinkedIn</a>
            </div>
            <p>
                &copy; {{ date('Y') }} {{ $appName ?? 'MicroCredit' }}. Tous droits réservés.
            </p>
            <p class="copyright">
                Cet email est généré automatiquement. Veuillez ne pas y répondre.
            </p>
        </div>
    </div>
</body>
</html>
