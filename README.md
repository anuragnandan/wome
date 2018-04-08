# WOME

Recieve Home to Work and vice versa route notification with faster route every day. Get your Google API key and PushMe keys to run this.

```
docker pull anuragnandan/wome
```
For HOME->WORK
```
docker run --env KEY=somegooglekey 
           --env NOTIFY_KEY=somepushmekey 
           wome run-script morning
```
For WORK->HOME
```
docker run --env KEY=somegooglekey 
           --env NOTIFY_KEY=somepushmekey 
           wome run-script evening
```

### Requires
- [Google Maps API](https://developers.google.com/maps/documentation/javascript/get-api-key)
- [Push Me](https://pushme.jagcesar.se/)
