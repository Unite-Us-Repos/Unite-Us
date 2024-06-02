export const countdown = async () => {
  var timer;
  var now = new Date();
  // CURRENT DATE AND TIME
  var now = new Date();

  let countdownTimer = document.getElementsByClassName('countdown');
  const countdownDate = countdownTimer[0].getAttribute('data-date');
  const timezone= countdownTimer[0].getAttribute('data-timezone');

  // SET DATE TO SPECIFIC DAY IN THE FUTURE
  // MONTHS go from 0 to 11: January is 0, February is 1, and so on
  var then = new Date(countdownDate);
  // OR COUNT DOWN TO 3 DAYS IN THE FUTURE
  // var then = now.getTime() + (3 * 24 * 60 * 60 * 1000);

  // CALCULATE TIMEZONE OFFSET
  // USING MOMENT.JS SET LOCAL TIMEZONE - IN THIS CASE "EUROPE/LONDON"
  // See full list of timezones here - https://gist.github.com/diogocapela/12c6617fc87607d11fd62d2a4f42b02a
  var utcOffset = moment.tz(moment.utc(), timezone).utcOffset()
  // CALCULATE UTC OFFSET USING MOMENT.JS
  var localOffset = moment().utcOffset();
  // CALCULATE RELATIVE OFFSET
  var offset = utcOffset - localOffset

  var compareDate = new Date(then) - now.getDate() - (offset * 60 * 1000);
  timer = setInterval(function() {
    timeBetweenDates(compareDate);
  }, 1000);

  function timeBetweenDates(toDate) {
    var dateEntered = new Date(toDate);
    var now = new Date();
    var difference = dateEntered.getTime() - now.getTime();

    if (difference <= 0) {

      document.getElementById("days").innerHTML = 0;
      document.getElementById("hours").innerHTML = 0;
      document.getElementById("minutes").innerHTML = 0;
      document.getElementById("seconds").innerHTML = 0;

    } else {

      var seconds = Math.floor(difference / 1000);
      var minutes = Math.floor(seconds / 60);
      var hours = Math.floor(minutes / 60);
      var days = Math.floor(hours / 24);

      hours %= 24;
      minutes %= 60;
      seconds %= 60;

      document.getElementById("days").innerHTML = days;
      document.getElementById("hours").innerHTML = hours;
      document.getElementById("minutes").innerHTML = minutes;
      document.getElementById("seconds").innerHTML = seconds;
    }
  }
}

