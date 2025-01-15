function Clock() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };
    const formattedTime = now.toLocaleString('en-US', options)
    document.getElementById('liveClock').textContent = formattedTime;
}
setInterval(Clock, 1000)
Clock();