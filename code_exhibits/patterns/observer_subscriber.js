var NewYorkTimes = new Publisher;
var AustinHerald = new Publisher;
var SfChronicle = new Publisher;


var Joe = function(from) {
    console.log('Delivery from ' + from + ' to Joe');
};
var Lindsay = function(from) {
    console.log('Delivery from ' + from + ' to Lindsay');
};
var Quadaras = function(from) {
    console.log('Delivery from ' + from + ' to Quadaras');
};


/*
 * Here we allow them to subscribe to newspapers,
 * which are the Publisher objects.
 */

Joe.
    subscribe(NewYorkTimes).
    subscribe(SfChronicle);

Lindsay.
    subscribe(AustinHerald).
    subscribe(SfChronicle).
    subscribe(NewYorkTimes);

Quadaras.
    subscribe(AustinHerald).
    subscribe(SfChronicle);

/*
 * Then at any given time in our application, our publishers can send
 * off data for the subscribers to consume and react to.
 */
NewYorkTimes.
    deliver('Here is your paper!  Direct from the Big Apple!');
AustinHerald.
    deliver('News').
    deliver('Reviews').
    deliver('Coupons');
SfChronicle.
    deliver('The weather is still chilly').
    deliver('Hi Mom!  I\'m writing a book!');

