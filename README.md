# ProcessPodcastSubscriptions

## What it does

Subscribe Podcast RSS feed and save as something you want.
It used the great PHP Library [podcast-feed-parser](https://github.com/lukaswhite/podcast-feed-parser) by
Lukas White and adds some processwire magic. Thanks!

## Features
- Subscribe / Unsubscribe Podcast XML-Feeds
- Periodically fetch files with LazyCron
- Simple Hookable Actions
- ProcessModule for Administration

## Install

1. Copy the files for this module to /site/modules/ProcessPodcastSubscriptions/
2. Execute the following command in the /site/modules/ProcessPodcastSubscriptions/ directory.
   ```bash
   composer install
   ```
3. If not done automatically, create a new admin page with the process `ProcessPodcastSubscriptions`
4. Subscribe Podcast feeds...

## Configuration

`Modules` > `Configure` > `ProcessPodcastSubscriptions`

### Lazycron
Setup the Lazycron schedule. The cache expiration is configurable in the field settings.

![Lazycron](https://user-images.githubusercontent.com/11630948/116866358-8e7b6000-ac0b-11eb-8793-a5a06546ff09.png)

### Podcast Class
The podcast object is the original object from podcast-feed-parser and has a lot of brilliant methods. Here is a [complete documentation](https://htmlpreview.github.io/?https://github.com/lukaswhite/podcast-feed-parser/blob/main/docs/html/classes/Lukaswhite_PodcastFeedParser_Podcast.xhtml) 

### Episode Class
https://htmlpreview.github.io/?https://raw.githubusercontent.com/lukaswhite/podcast-feed-parser/main/docs/html/classes/Lukaswhite_PodcastFeedParser_Episode.xhtml

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


### Example Action: create page per Episode

- Create Fields: title, decription, episodenumber, podcastId, image field
- Hook 
- add image helper function


## Todos
- add fields (install, checkbox/button)
- add template (install, checkbox/button)
- 
- respect lastBuildDate for call update action
  strtotime('01:00:00') - strtotime('TODAY'); // 3600