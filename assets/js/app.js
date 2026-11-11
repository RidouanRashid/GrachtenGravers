const stops = Array.isArray(window.routeStops) && window.routeStops.length ? window.routeStops : [
  {
    id: 'gaardbrug',
    title: 'Gaardbrug',
    time: 0,
    x: 112,
    y: 320,
    description: 'De route begint bij de Gaardbrug.',
    sources: [{ label: 'Archiefbron', href: '#' }, { label: 'Kaart', href: '#' }]
  }
];

const routeVideo = document.getElementById('routeVideo');
const playPauseButton = document.getElementById('playPause');
const prevStopButton = document.getElementById('prevStop');
const nextStopButton = document.getElementById('nextStop');
const toggleMapModeButton = document.getElementById('toggleMapMode');
const mapPanel = document.querySelector('.map-panel');
const markersLayer = document.getElementById('markersLayer');
const locationTitle = document.getElementById('locationTitle');
const locationDescription = document.getElementById('locationDescription');
const sourceList = document.getElementById('sourceList');

function renderMarkers() {
  const group = document.createElementNS('http://www.w3.org/2000/svg', 'g');

  stops.forEach((stop, index) => {
    const marker = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    marker.setAttribute('class', 'map-marker');
    marker.setAttribute('tabindex', '0');
    marker.dataset.index = String(index);
    marker.dataset.time = String(stop.time);
    marker.setAttribute('transform', `translate(${stop.x}, ${stop.y})`);
    marker.setAttribute('aria-label', stop.title);

    const pulse = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    pulse.setAttribute('class', 'pulse');
    pulse.setAttribute('r', '23');
    pulse.setAttribute('cx', '0');
    pulse.setAttribute('cy', '0');

    const outer = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    outer.setAttribute('r', '14');
    outer.setAttribute('cx', '0');
    outer.setAttribute('cy', '0');

    const label = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    label.setAttribute('x', '18');
    label.setAttribute('y', '-16');
    label.textContent = stop.title;

    marker.appendChild(pulse);
    marker.appendChild(outer);
    marker.appendChild(label);

    marker.addEventListener('click', () => jumpToStop(index));
    marker.addEventListener('keydown', (event) => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        jumpToStop(index);
      }
    });

    group.appendChild(marker);
  });

  markersLayer.innerHTML = '';
  markersLayer.appendChild(group);
}

function jumpToStop(index) {
  const stop = stops[index];
  routeVideo.currentTime = stop.time;
  routeVideo.play();
  updateActiveStop();
}

function getCurrentStop() {
  let active = stops[0];
  for (const stop of stops) {
    if (routeVideo.currentTime >= stop.time) {
      active = stop;
    }
  }
  return active;
}

function updateActiveStop() {
  const current = getCurrentStop();
  const activeIndex = stops.findIndex((stop) => stop.id === current.id);

  document.querySelectorAll('.map-marker').forEach((marker, index) => {
    marker.classList.toggle('active', index === activeIndex);
  });

  locationTitle.textContent = current.title;
  locationDescription.textContent = current.description;
  sourceList.innerHTML = current.sources.map((source) => `
    <li><a href="${source.href}">${source.label}</a></li>
  `).join('');
}

function togglePlayPause() {
  if (routeVideo.paused) {
    routeVideo.play();
  } else {
    routeVideo.pause();
  }
}

function moveToAdjacentStop(direction) {
  const currentIndex = stops.findIndex((stop) => stop.id === getCurrentStop().id);
  const nextIndex = Math.min(Math.max(currentIndex + direction, 0), stops.length - 1);
  jumpToStop(nextIndex);
}

routeVideo.addEventListener('timeupdate', updateActiveStop);
playPauseButton.addEventListener('click', togglePlayPause);
prevStopButton.addEventListener('click', () => moveToAdjacentStop(-1));
nextStopButton.addEventListener('click', () => moveToAdjacentStop(1));
routeVideo.addEventListener('play', () => {
  playPauseButton.textContent = 'Pauzeren';
});
routeVideo.addEventListener('pause', () => {
  playPauseButton.textContent = 'Afspelen';
});

toggleMapModeButton.addEventListener('click', () => {
  mapPanel.classList.toggle('is-3d');
  toggleMapModeButton.textContent = mapPanel.classList.contains('is-3d') ? '2D kaart' : '3D kaart';
});

renderMarkers();
updateActiveStop();
