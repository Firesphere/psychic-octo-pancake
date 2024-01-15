# silverstripe-flash-messages

for flashing dem messages

_For SilverStripe 3 compatibility, use v1.0.0._

## Usage

`composer require cheddam/silverstripe-flash-messages`

In controller methods:

`$this->flashMessage('She drove me here', 'warning');`

In templates:

```php
<% if $FlashMessagesPresent %>
	<% loop $FlashMessages %>
		<div class="message message--$Type">$Message</div>
	<% end_loop %>
<% end_if %>
```

## Caveats

- $FlashMessages can only be called once as it clears the messages from the session before returning them.
