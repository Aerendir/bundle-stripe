<p align="center">
    <a href="http://www.serendipityhq.com" target="_blank">
        <img src="http://www.serendipityhq.com/assets/open-source-projects/Logo-SerendipityHQ-Icon-Text-Purple.png">
    </a>
</p>

SHQ STRIPE BUNDLE
=================

[![PHP from Packagist](https://img.shields.io/packagist/php-v/serendipity_hq/stripe-bundle?color=%238892BF)](https://packagist.org/packages/serendipity_hq/stripe-bundle)
[![Tested with Symfony ^3.0](https://img.shields.io/badge/Symfony-%5E3.0-333)](https://github.com/Aerendir/stripe-bundle/actions)
[![Tested with Symfony ^4.0](https://img.shields.io/badge/Symfony-%5E4.0-333)](https://github.com/Aerendir/stripe-bundle/actions)
[![Tested with Symfony ^5.0](https://img.shields.io/badge/Symfony-%5E5.0-333)](https://github.com/Aerendir/stripe-bundle/actions)

[![Latest Stable Version](https://poser.pugx.org/serendipity_hq/stripe-bundle/v/stable.png)](https://packagist.org/packages/serendipity_hq/stripe-bundle)
[![Total Downloads](https://poser.pugx.org/serendipity_hq/stripe-bundle/downloads.svg)](https://packagist.org/packages/serendipity_hq/stripe-bundle)
[![License](https://poser.pugx.org/serendipity_hq/stripe-bundle/license.svg)](https://packagist.org/packages/serendipity_hq/stripe-bundle)

[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_stripe-bundle&metric=coverage)](https://sonarcloud.io/dashboard?id=Aerendir_stripe-bundle)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_stripe-bundle&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=Aerendir_stripe-bundle)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_stripe-bundle&metric=alert_status)](https://sonarcloud.io/dashboard?id=Aerendir_stripe-bundle)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_stripe-bundle&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=Aerendir_stripe-bundle)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_stripe-bundle&metric=security_rating)](https://sonarcloud.io/dashboard?id=Aerendir_stripe-bundle)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_stripe-bundle&metric=sqale_index)](https://sonarcloud.io/dashboard?id=Aerendir_stripe-bundle)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=Aerendir_stripe-bundle&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=Aerendir_stripe-bundle)

![Phan](https://github.com/Aerendir/stripe-bundle/workflows/Phan/badge.svg)
![PHPStan](https://github.com/Aerendir/stripe-bundle/workflows/PHPStan/badge.svg)
![PSalm](https://github.com/Aerendir/stripe-bundle/workflows/PSalm/badge.svg)
![PHPUnit](https://github.com/Aerendir/stripe-bundle/workflows/PHPunit/badge.svg)
![Composer](https://github.com/Aerendir/stripe-bundle/workflows/Composer/badge.svg)
![PHP CS Fixer](https://github.com/Aerendir/stripe-bundle/workflows/PHP%20CS%20Fixer/badge.svg)
![Rector](https://github.com/Aerendir/stripe-bundle/workflows/Rector/badge.svg)

SerendipityHQ Stripe Bundle integrates your Symfony app with the Stripe payment service.

SerendipityHQ Stripe Bundle gives you the ability to perform common tasks calling the Stripe's API and exposes an endpoint to which you can receive the notifications sent by Stripe via Webhooks.

*Do you like this bundle? [**Leave a &#9733;**](#js-repo-pjax-container) or run `composer global require symfony/thanks && composer thanks` to say thank you to all libraries you use in your current project, this one too!*

How to use the Serendipity HQ Stripe Bundle
-------------------------------------------

SerendipityHQ Stripe Bundle persists all the communications between your app and the Stripe's API so you ever have a local copy of them, without needing to communicate with the API to retrieve relevant information. This makes your app able to perform a lot of tasks also if there are issues with the
Stripe's API (very rare, but anyway possible).
Maintain these information as a local copy is considered a best practice, so you should do it.

SerendipityHQ Stripe Bundle fires events for each possible action, so you can hook them to make you app able to react to them.
For example, if the endpoint receives a Refund Event from the Stripe's API, your app can update the subscription of the Customer's refunded card.

SerendipityHQ Stripe Bundle contains the code to incorporate a form on your pages from which you can get the credit cards details, send them in a Stripe's secured SSL channel (also if your app hasn't SSL encryption enabled!) and save its representation on the database for later charge.

See the documentation for the full list of features.

Requirements
------------

1. PHP ^7.1

Status: ACTIVE DEVELOPMENT
--------------------------

This bundle is currently in development mode. We use it in our live projects and so we try to maintain it in good health.

Currently not all Stripe's API features are implemented, only the ones we currently need and can test on the wild.

It is as stable as possible. If you, using it, find bugs or scenarios not covered, please, open an issue describing the problem.

All issues are reviewd and fixed.

If you have a feature request, equally, please, open an issue and we will review it and evaluate if it may be implemented.

Thank you for your collaboration.

DOCUMENTATION
=============

You can read how to install, configure, test and use the SerendipityHQ Stripe Bundle in the [documentation](docs/Index.md).
