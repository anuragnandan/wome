# WOME

Recieve Home to Work and vice versa route notification with faster route every day. Get your Google API key and PushMe keys to run this.

```
docker build -t wome .
docker run --env KEY=somegooglekey --env NOTIFY_KEY=somepushmekey wome php /app/main.php
```

### Requires
- [Google Maps API](https://developers.google.com/maps/documentation/javascript/get-api-key)
- [Push Me](https://pushme.jagcesar.se/)
