<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>Bienvenue — MicroCredit</title>
</head>
<body style="margin:0; padding:0; background-color:#050B12; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; color:#E9F2F7;">

    <!-- Preheader (hidden) -->
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">
        Votre compte MicroCredit est prêt.
    </div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#050B12;">
        <tr>
            <td align="center" style="padding:24px 14px;">

                <!-- Container -->
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width:600px; width:100%;">

                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding:10px 0 18px;">
                            <div style="font-size:22px; font-weight:800; letter-spacing:0.2px;">
                                MicroCredit
                            </div>
                            <div style="margin-top:6px; width:110px; height:3px; background:#00C45A; border-radius:999px; opacity:0.9;"></div>
                        </td>
                    </tr>

                    <!-- Badge -->
                    <tr>
                        <td>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#0D1823; border:1px solid #142634; border-radius:16px; padding:18px;">
                                <tr>
                                    <td style="vertical-align:middle;">
                                    </td>
                                    <td style="padding-left:12px; vertical-align:middle;">
                                        <div style="font-size:16px; font-weight:700; margin-top:2px;"> Bienvenue Compte prêt</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td style="padding:22px 0 10px;">
                            <div style="font-size:26px; font-weight:900; line-height:1.2;">
                                Bienvenue {{ $user->name }}
                            </div>
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td style="padding:0 0 14px;">
                            <div style="font-size:15px; color:#E9F2F7; line-height:1.6;">
                                Votre compte a été créé avec succès.
                            </div>
                        </td>
                    </tr>

                    <!-- Benefits card -->
                    <tr>
                        <td>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#07131B; border:1px solid #142634; border-radius:16px; padding:18px;">
                                <tr>
                                    <td style="padding-bottom:10px;">
                                        <div style="font-size:14px; font-weight:800;">Avec MicroCredit, vous pouvez :</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding:10px 0;">
                                                    <div style="display:flex;">
                                                        <div style="display:inline-block; width:26px; height:26px; border-radius:9px; background:rgba(0,196,90,0.16); border:1px solid rgba(0,196,90,0.32); text-align:center; line-height:26px;">
                                                            <span style="font-size:13px;">1</span>
                                                        </div>
                                                        <div style="display:inline-block; padding-left:10px; vertical-align:top;">
                                                            <div style="font-size:14px; font-weight:700;">Soumettre une demande de crédit</div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px 0;">
                                                    <div style="display:flex;">
                                                        <div style="display:inline-block; width:26px; height:26px; border-radius:9px; background:rgba(0,196,90,0.16); border:1px solid rgba(0,196,90,0.32); text-align:center; line-height:26px;">
                                                            <span style="font-size:13px;">2</span>
                                                        </div>
                                                        <div style="display:inline-block; padding-left:10px; vertical-align:top;">
                                                            <div style="font-size:14px; font-weight:700;">Suivre les remboursements</div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px 0;">
                                                    <div style="display:flex;">
                                                        <div style="display:inline-block; width:26px; height:26px; border-radius:9px; background:rgba(0,196,90,0.16); border:1px solid rgba(0,196,90,0.32); text-align:center; line-height:26px;">
                                                            <span style="font-size:13px;">3</span>
                                                        </div>
                                                        <div style="display:inline-block; padding-left:10px; vertical-align:top;">
                                                            <div style="font-size:14px; font-weight:700;">Gérer son profil</div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px 0;">
                                                    <div style="display:flex;">
                                                        <div style="display:inline-block; width:26px; height:26px; border-radius:9px; background:rgba(0,196,90,0.16); border:1px solid rgba(0,196,90,0.32); text-align:center; line-height:26px;">
                                                            <span style="font-size:13px;">4</span>
                                                        </div>
                                                        <div style="display:inline-block; padding-left:10px; vertical-align:top;">
                                                            <div style="font-size:14px; font-weight:700;">Consulter l'historique des opérations</div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA button -->
                    <tr>
                        <td align="center" style="padding:18px 0 8px;">
                            <a href="{{ config('app.url') }}/login" style="display:inline-block; background:#00C45A; color:#07131B; font-weight:900; text-decoration:none; padding:14px 22px; border-radius:16px; border:1px solid rgba(61,255,122,0.35); box-shadow:0 10px 30px rgba(0,196,90,0.25);">
                                Accéder à mon compte
                            </a>
                        </td>
                    </tr>

                    <!-- Security reassurance -->
                    <tr>
                        <td style="padding:8px 0 18px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#0D1823; border:1px solid #142634; border-radius:16px; padding:14px 16px;">
                                <tr>
                                    <td style="vertical-align:middle; width:44px;">
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <div style="font-size:14px; font-weight:800;">Sécurité & confidentialité</div>
                                        <div style="font-size:13px; color:#AEBBC6; margin-top:3px; line-height:1.5;">
                                            Vos opérations sont protégées et traçables. Activez la double authentification dans votre profil.
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding:14px 0 0;">
                            <div style="font-size:12px; color:#AEBBC6; line-height:1.6;">
                                © {{ now()->year }} MicroCredit. Tous droits réservés.
                                <br />
                                Contact : support@microcredit.example
                            </div>
                        </td>
                    </tr>

                </table>
                <!-- /Container -->

            </td>
        </tr>
    </table>

</body>
</html>

