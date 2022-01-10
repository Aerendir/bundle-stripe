<p align="center">
    <a href="http://www.serendipityhq.com" target="_blank">
        <img style="max-width: 350px" src="http://www.serendipityhq.com/assets/open-source-projects/Logo-SerendipityHQ-Icon-Text-Purple.png">
    </a>
</p>

<h1 align="center">Serendipity HQ Stripe Bundle</h1>
<p align="center">Integrates your Symfony app with the Stripe payment service.</p>
<p align="center">
    <a href="https://github.com/Aerendir/bundle-stripe/releases"><img src="https://img.shields.io/packagist/v/serendipity_hq/bundle-stripe.svg?style=flat-square"></a>
    <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square"></a>
    <a href="https://github.com/Aerendir/bundle-stripe/releases"><img src="https://img.shields.io/packagist/php-v/serendipity_hq/bundle-stripe?color=%238892BF&style=flat-square&logo=php" /></a>
</p>
<p>
    Supports:
    <a title="Supports Symfony ^4.4" href="https://github.com/Aerendir/bundle-aws-ses-monitor/actions?query=branch%3Adev"><img title="Supports Symfony ^4.4" src="https://img.shields.io/badge/Symfony-%5E4.4-333?style=flat-square&logo=symfony" /></a>
    <a title="Supports Symfony ^5.4" href="https://github.com/Aerendir/bundle-aws-ses-monitor/actions?query=branch%3Adev"><img title="Supports Symfony ^5.4" src="https://img.shields.io/badge/Symfony-%5E5.4-333?style=flat-square&logo=symfony" /></a>
    <a title="Supports Symfony ^6.0" href="https://github.com/Aerendir/bundle-aws-ses-monitor/actions?query=branch%3Adev"><img title="Supports Symfony ^6.0" src="https://img.shields.io/badge/Symfony-%5E6.0-333?style=flat-square&logo=symfony" /></a>
</p>
<p>
    Tested with:
    <a title="Tested with Symfony ^4.4" href="https://github.com/Aerendir/bundle-aws-ses-monitor/actions?query=branch%3Adev"><img title="Tested with Symfony ^4.4" src="https://img.shields.io/badge/Symfony-%5E4.4-333?style=flat-square&logo=symfony" /></a>
    <a title="Tested with Symfony ^5.4" href="https://github.com/Aerendir/bundle-aws-ses-monitor/actions?query=branch%3Adev"><img title="Tested with Symfony ^5.4" src="https://img.shields.io/badge/Symfony-%5E5.4-333?style=flat-square&logo=symfony" /></a>
    <a title="Tested with Symfony ^6.0" href="https://github.com/Aerendir/bundle-aws-ses-monitor/actions?query=branch%3Adev"><img title="Tested with Symfony ^6.0" src="https://img.shields.io/badge/Symfony-%5E6.0-333?style=flat-square&logo=symfony" /></a>
</p>
<p align="center">
    <a href="https://www.php.net/manual/en/book.json.php"><img src="https://img.shields.io/badge/Requires-ext--json-%238892BF?style=flat-square&logo=php"></a>
</p>

## Current Status

[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_bundle-stripe&metric=coverage)](https://sonarcloud.io/dashboard?id=Aerendir_bundle-stripe)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_bundle-stripe&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=Aerendir_bundle-stripe)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_bundle-stripe&metric=alert_status)](https://sonarcloud.io/dashboard?id=Aerendir_bundle-stripe)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_bundle-stripe&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=Aerendir_bundle-stripe)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_bundle-stripe&metric=security_rating)](https://sonarcloud.io/dashboard?id=Aerendir_bundle-stripe)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_bundle-stripe&metric=sqale_index)](https://sonarcloud.io/dashboard?id=Aerendir_bundle-stripe)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_bundle-stripe&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=Aerendir_bundle-stripe)

[![Phan](https://github.com/Aerendir/bundle-stripe/workflows/Phan/badge.svg)](https://github.com/Aerendir/bundle-stripe/actions?query=branch%3Adev)
[![PHPStan](https://github.com/Aerendir/bundle-stripe/workflows/PHPStan/badge.svg)](https://github.com/Aerendir/bundle-stripe/actions?query=branch%3Adev)
[![PSalm](https://github.com/Aerendir/bundle-stripe/workflows/PSalm/badge.svg)](https://github.com/Aerendir/bundle-stripe/actions?query=branch%3Adev)
[![PHPUnit](https://github.com/Aerendir/bundle-stripe/workflows/PHPunit/badge.svg)](https://github.com/Aerendir/bundle-stripe/actions?query=branch%3Adev)
[![Composer](https://github.com/Aerendir/bundle-stripe/workflows/Composer/badge.svg)](https://github.com/Aerendir/bundle-stripe/actions?query=branch%3Adev)
[![PHP CS Fixer](https://github.com/Aerendir/bundle-stripe/workflows/PHP%20CS%20Fixer/badge.svg)](https://github.com/Aerendir/bundle-stripe/actions?query=branch%3Adev)
[![Rector](https://github.com/Aerendir/bundle-stripe/workflows/Rector/badge.svg)](https://github.com/Aerendir/bundle-stripe/actions?query=branch%3Adev)

## Features

SerendipityHQ Stripe Bundle gives you the ability to perform common tasks calling the Stripe's API and exposes an endpoint to which you can receive the notifications sent by Stripe via Webhooks.

<hr />
<h3 align="center">
    <b>Do you like this bundle?</b><br />
    <b><a href="#js-repo-pjax-container">LEAVE A &#9733;</a></b>
</h3>
<p align="center">
    or run<br />
    <code>composer global require symfony/thanks && composer thanks</code><br />
    to say thank you to all libraries you use in your current project, this included!
</p>
<hr />

How to use the Serendipity HQ Stripe Bundle
-------------------------------------------

SerendipityHQ Stripe Bundle persists all the communications between your app and the Stripe's API so you ever have a local copy of them, without needing to communicate with the API to retrieve relevant information. This makes your app able to perform a lot of tasks also if there are issues with the
Stripe's API (very rare, but anyway possible).
Maintain these information as a local copy is considered a best practice, so you should do it.

SerendipityHQ Stripe Bundle fires events for each possible action, so you can hook them to make you app able to react to them.
For example, if the endpoint receives a Refund Event from the Stripe's API, your app can update the subscription of the Customer's refunded card.

SerendipityHQ Stripe Bundle contains the code to incorporate a form on your pages from which you can get the credit cards details, send them in a Stripe's secured SSL channel (also if your app hasn't SSL encryption enabled!) and save its representation on the database for later charge.

See the documentation for the full list of features.

DOCUMENTATION
=============

You can read how to install, configure, test and use the SerendipityHQ Stripe Bundle in the [documentation](docs/Index.md).

<hr />
<h3 align="center">
    <b>Do you like this bundle?</b><br />
    <b><a href="#js-repo-pjax-container">LEAVE A &#9733;</a></b>
</h3>
<p align="center">
    or run<br />
    <code>composer global require symfony/thanks && composer thanks</code><br />
    to say thank you to all libraries you use in your current project, this included!
</p>
<hr />
