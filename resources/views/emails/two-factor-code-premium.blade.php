<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>Code de vérification — MicroCredit</title>
</head>
<body style="margin:0; padding:0; background-color:#050B12; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; color:#E9F2F7;">

    <!-- Preheader -->
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">
        Votre code de vérification MicroCredit.
    </div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#050B12;">
        <tr>
            <td align="center" style="padding:24px 14px;">

                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width:600px; width:100%;">

                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding:8px 0 18px;">
                            <div style="font-size:22px; font-weight:900; letter-spacing:0.2px;">MicroCredit</div>
                            <div style="margin-top:6px; width:140px; height:3px; background:#00C45A; border-radius:999px; opacity:0.9;"></div>
                        </td>
                    </tr>

                    <!-- Security badge -->
                    <tr>
                        <td>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#0D1823; border:1px solid #142634; border-radius:16px; padding:18px 18px;">
                                <tr>
                                    <td style="width:44px; vertical-align:middle;">
                                        <div style="width:36px; height:36px; border-radius:12px; background:rgba(0,196,90,0.16); border:1px solid rgba(0,196,90,0.35); text-align:center; line-height:36px;">
                                            <span style="font-size:16px;">🛡️</span>
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <div style="font-size:13px; color:#AEBBC6; text-transform:uppercase; letter-spacing:0.9px;">Sécurité</div>
                                        <div style="font-size:16px; font-weight:800; margin-top:2px;">Code de vérification</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:18px 0 8px;">
                            <div style="font-size:15px; line-height:1.7; color:#E9F2F7;">
                                Bonjour {{ $user->name ?? $name ?? '' }},
                                <br /><br />
                                Pour sécuriser votre compte MicroCredit, veuillez utiliser le code de vérification ci-dessous.
                            </div>
                        </td>
                    </tr>

                    <!-- OTP block -->
                    <tr>
                        <td style="padding:16px 0 10px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#07131B; border:1px solid #142634; border-radius:16px; padding:18px 16px;">
                                <tr>
                                    <td align="center" style="padding:6px 0 2px;">
                                        <div style="font-size:12px; color:#AEBBC6; text-transform:uppercase; letter-spacing:0.9px;">Votre code</div>
                                        <div style="margin-top:10px; background:rgba(0,196,90,0.10); border:1px solid rgba(0,196,90,0.55); border-radius:14px; padding:14px 16px;">
                                            <span style="display:inline-block; font-size:28px; font-weight:900; color:#00C45A; letter-spacing:10px;">
                                                {{ $otpCode ?? $code ?? $OTP_CODE ?? '' }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Validity -->
                    <tr>
                        <td style="padding:6px 0 6px;">
                            <div style="font-size:14px; color:#E9F2F7; line-height:1.6;">
                                Ce code est valable pendant <strong>10 minutes</strong>.
                            </div>
                        </td>
                    </tr>

                    <!-- Security alert -->
                    <tr>
                        <td style="padding:10px 0 18px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#0D1823; border:1px solid #142634; border-radius:16px; padding:14px 14px;">
                                <tr>
                                    <td style="vertical-align:middle; width:44px;">
                                        <div style="width:36px; height:36px; border-radius:12px; background:rgba(61,255,122,0.16); border:1px solid rgba(61,255,122,0.35); text-align:center; line-height:36px;">
                                            <span style="font-size:16px;">⚠️</span>
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <div style="font-size:14px; font-weight:900;">Ne partagez jamais ce code</div>
                                        <div style="font-size:13px; color:#AEBBC6; line-height:1.6; margin-top:3px;">
                                            Aucun employé de MicroCredit ne vous le demandera.
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding:0 0 8px;">
                            <div style="font-size:12px; color:#AEBBC6; line-height:1.6;">
                                Si vous n'avez pas effectué cette demande, veuillez ignorer cet email ou contacter notre support.
                                <br />
                                <span>support@microcredit.example</span>
                            </div>
                            <div style="margin-top:10px; font-size:12px; color:#AEBBC6;">
                                © {{ now()->year }} MicroCredit. Tous droits réservés.
                            </div>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>
</html>

