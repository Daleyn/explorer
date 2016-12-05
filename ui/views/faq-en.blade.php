@extends('layout')

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <div class="staticPage">
                    <div class="staticPage-inner">

                        <h1>Frequently Asked Questions</h1>

                        <h4>Are there any fees to use the BTC.com wallet?</h4>
                        <p>
                            BTC.com does not charge any fees to use the wallet, and the app is always free to download.
                            Your transactions will need to include network mining fees, which are paid to the Bitcoin network for your transactions to confirm.
                        </p>
                        <h4>How do I send bitcoin directly to my contacts?</h4>
                        <p>
                            You are able to directly send BTC to the contacts on your mobile device if they are also a BTC.com wallet user. Just select a contact from your phone's address book, enter an amount, and click send.  Using HD wallet technology, we find the wallet associated with your friend's phone number, and create a new bitcoin address for you to send to.  If your contact is not a user, we give you the option to send an SMS inviting them to join.
                        </p>
                        <h4>Where can I use my wallet?</h4>
                        <p>
                            You can use your wallet at any location or website that accepts bitcoin. You can also use it to send and receive bitcoin with other bitcoin users and services.
                        </p>
                        <h4>How do I send bitcoin?</h4>
                        <p>
                            You can send bitcoin by logging into your wallet, and clicking the send button on the website or in the app.  You can send to a bitcoin address, QR code or contact.
                        </p>
                        <h4>How do I receive Bitcoin?</h4>
                        <p>
                            You can receive bitcoin by logging into your wallet, clicking the receive button on the website or in the app.  A new address and QR code will be generated for you.  You can copy, email or SMS this information to the relevant party.  You can also request a payment to be made in the app.
                        </p>

                        <h4>Can I buy or sell Bitcoin through the BTC.com wallet?</h4>
                        <p>
                            Not yet, but we are working on it.
                        </p>

                        <h4>Do I retain ownership of my private keys?</h4>
                        <p>
                            Yes! Using BTC.com wallet, you are the owner of your private keys. BTC.com never has access to your bitcoins.
                        </p>

                        <h4>What type of security does a BTC.com wallet provide?</h4>
                        <p>
                            BTC.com uses strong cryptography that includes Multi-Signature and HD Technology. Also, since we never have access to your private keys, we further protect your bitcoins.
                        </p>
<!--
                        <h4>How does BTC.com use multi-signature ?</h4>
                        <p>
                            Transactions from your BTC.com wallet are co-signed both by you on your device, and by BTC.com.
                            When you enable two-factor authentication, BTC.com only signs transactions which you have authenticated on your secondary device.
                            Using multi-signature transactions and multi-device authentication
                            allows BTC.com to provide you with the highest level of security for your Bitcoin.
                        </p>
//-->
                        <h4>How does BTC.com use HD wallet technology? </h4>
                        <p>
                            BTC.com wallets are Hierarchical Deterministic (HD) by default. This enables you to generate an unlimited amount of
                            Bitcoin addresses, without ever having to create a new backup. Using BTC.com's backup recovery document you are always able to
                            both restore bitcoins stored on the wallet, as well as regenerate all addresses associated with it.
                        </p>

                        <h4>What happens to my bitcoin if BTC.com service is not available?</h4>
                        <p>
                            If BTC.com is ever unavailable, you are always able to restore your wallet using the BTC.com backup recovery document.
                            This document is not specific to BTC.com, and can work with Bitcoin-core directly.
                        </p>

                        <h4>How do I backup my wallet?</h4>
                        <p>
                            When you create your wallet for the first time you will be prompted to download a backup recovery document.
                            This document is your master backup and will be able to restore your wallet as well as any addresses associated with it.
                            This document allows direct access to your wallet and should be kept confidential and stored securely offline.
                        </p>

                        <h4>What is two-factor authentication?</h4>
                        <p>
                            When enabled, two factor authentication will require you to authorize your login attempts and transactions using more than one device.
                            BTC.com uses Google Authenticator/Authy for two factor authentication.
                        </p>

                        <h4>Is BTC.com available on mobile?</h4>
                        <p>
                            Yes, BTC.com wallet is a multi-platform wallet available on both
                            <a href="https://itunes.apple.com/us/app/blocktrail-bitcoin-wallet/id1019614423">iOS</a>
                            and
                            <a href="https://play.google.com/store/apps/details?id=com.blocktrail.mywallet">Android</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
