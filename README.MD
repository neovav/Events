Events libs
============

This is sample how use Events libs with Notifier

<!-- [START getstarted] -->
## Getting Started

### Installation

For installations neovav/Events, run:

```bash
git clone https://github.com/neovav/Events
cd Events
composer install
```

### Usage

```php
use \neovav\Events\Subscriber;
use \neovav\Events\Notifier;
use \neovav\Events\INotice;

require_once '..\vendor\autoload.php';

$func = function (INotice $notice) {
    echo "\r\n", 'DEBUG          => ', $notice->getEventName();
    if ($notice->isEventData()) var_dump($notice->getEventData());
};

try {
    $subscr_dbg = new Subscriber('DEBUG@Start', $func);
    Notifier::attach($subscr_dbg);
} catch(Exception $e) {var_dump($e);};

$notice_dbg = new Notice(__FILE__,'DEBUG@Start');

Notifier::notify($notice_dbg);

Notifier::detach($subscr_dbg);
```

For more samples view in directory : samples
Main file in samples: samples/sample.php