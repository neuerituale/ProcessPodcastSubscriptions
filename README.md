# ProcessPodcastSubscriptions

## What it does

Subscribe to podcast RSS feeds and save the data as anything you want.
The module uses the great PHP Library [podcast-feed-parser](https://github.com/lukaswhite/podcast-feed-parser) by
Lukas White, which makes processing the podcast data a breeze. Thanks!

The module comes with an example module `ProcessPodcastSubscriptionsEpisodes` to demonstrate how to create new pages per episode.

## Features
- Subscribe / Unsubscribe Podcast XML-Feeds
- Periodically fetch feeds with LazyCron
- Simple hookable actions
- ProcessModule for administration
- Optional module `ProcessPodcastSubscriptionsEpisodes`

## Install

1. Copy the files for this module to /site/modules/ProcessPodcastSubscriptions/
2. Execute the following command in the /site/modules/ProcessPodcastSubscriptions/ directory.
   ```bash
   composer install
   ```
3. If not done automatically, create a new admin page with the process `ProcessPodcastSubscriptions`
4. Install the additional module `ProcessPodcastSubscriptionsEpisodes` (optional) or build your own processor
5. Subscribe to Podcast feeds...


## Configuration Subscriptions

`Modules` > `Configure` > `ProcessPodcastSubscriptions`

###  Lazycron
Setup the LazyCron schedule. The cache expiration is configurable in the field settings.

![Lazycron](https://user-images.githubusercontent.com/11630948/154841723-e624ce01-eeb4-4938-9d23-f9b5c5636d95.png)

### Episode Meta
You can add subscribe links to the podcast.
Configure the providers and then attach the links to the podcast.

![Episode Parent](https://user-images.githubusercontent.com/11630948/190591854-cbe87d80-be1e-41f6-aaf9-c2b266c97382.png)

## Configuration Episodes

`Modules` > `Configure` > `ProcessPodcastSubscriptionsEpisodes`

### Episode Parent
Set parent page for new episode pages.

![Episode Parent](https://user-images.githubusercontent.com/11630948/154841724-b4c709a7-cb27-41d6-98a9-ea1ed73a742c.png)


## Podcast Class and Episode Class
The `Podcast` object has a lot of handy methods to do anything you want with the returned data.
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
   
   /* ... and much more ... */
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
    
    /* ... and much more ... */
}
```

## Hook
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

## Example Rendering
In the folder `ProcessPodcastSubscriptions/templates/podcasts-example.php` you will find a sample rendering for a podcast and episode list. Have fun with it.

![Episode Parent](https://user-images.githubusercontent.com/11630948/190590492-64fba28f-342b-4500-b074-03390ab5ba71.png)

## Todos
- Respect lastBuildDate from feed for update action.
- Handle long running script on subscribe.