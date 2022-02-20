# ProcessPodcastSubscriptions

## What it does

Subscribe Podcast RSS feed and save as something you want.
It used the great PHP Library [podcast-feed-parser](https://github.com/lukaswhite/podcast-feed-parser) by
Lukas White and adds some processwire magic. Thanks!

The additional example module `ProcessPodcastSubscriptionsEpisodes` create new pages per episode. This module is optional.

## Features
- Subscribe / Unsubscribe Podcast XML-Feeds
- Periodically fetch feeds with LazyCron
- Simple hookable actions
- ProcessModule for administration
- Optional module `ProcessPodcastSubscriptionsEpisodes` creates episode pages

## Install

1. Copy the files for this module to /site/modules/ProcessPodcastSubscriptions/
2. Execute the following command in the /site/modules/ProcessPodcastSubscriptions/ directory.
   ```bash
   composer install
   ```
3. If not done automatically, create a new admin page with the process `ProcessPodcastSubscriptions`
4. Install the additional module `ProcessPodcastSubscriptionsEpisodes`
5. Subscribe Podcast feeds...

## Configuration

`Modules` > `Configure` > `ProcessPodcastSubscriptions`

`Modules` > `Configure` > `ProcessPodcastSubscriptionsEpisodes`

### Lazycron
Setup the Lazycron schedule. The cache expiration is configurable in the field settings.

![Lazycron](https://user-images.githubusercontent.com/11630948/116866358-8e7b6000-ac0b-11eb-8793-a5a06546ff09.png)

### Podcast Class and Episode Class
The podcast object is the original object from podcast-feed-parser and has a lot of brilliant methods.
- [Podcast class](https://htmlpreview.github.io/?https://github.com/lukaswhite/podcast-feed-parser/blob/main/docs/html/classes/Lukaswhite_PodcastFeedParser_Podcast.xhtml)
- [Episode class](https://htmlpreview.github.io/?https://raw.githubusercontent.com/lukaswhite/podcast-feed-parser/main/docs/html/classes/Lukaswhite_PodcastFeedParser_Episode.xhtml)


```php
class Podcast implements HasArtwork {
   
   public array getEpisodes()
   public string getLanguage()
   public string getAuthor()
   public string getTitle()
   public string getSubtitle()
   public string getDescription()
   public DateTime getLastBuildDate()
   
   public string getType()
   public bool isEpisodic()
   public bool isSerial()
   
   public string getUpdatePeriod()
   public Artwork getArtwork()
   public string getExplicit()
   public array getCategories()
   
   /* ... and many more ... */
}
```

```php
class Episode {

    public string getGuid()
    public int getEpisodeNumber()
    public Media getMedia()
    public DateTime getPublishedDate()
    public string getTitle()
    public string getDescription()
    public Artwork getArtwork()
    public string getLink()
    public string getExplicit()
    
    /* ... and many more ... */
}
```

### Hook
```php

// init.php or ready.php
$wire->addHookBefore('ProcessPodcastSubscriptions::processPodcast', function (HookEvent $event) {

    /** @var \ProcessWire\WireData $feed */
    $feed = $event->arguments(0);

    /** @var \Lukaswhite\PodcastFeedParser\Podcast $podcast */
    $podcast = $event->arguments(1);
    
    // process
    foreach($podcast->getEpisodes() as $episode) {
        /* create or update episode pages... */
    }

});
```

## Todos
- respect lastBuildDate from feed for update action