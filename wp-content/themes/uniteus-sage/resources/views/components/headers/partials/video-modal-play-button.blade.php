<div class="flex align-center justify-center [&_[x-cloak]]:hidden">

    <!-- Video thumbnail -->
    <button
        id="openVideoModal"
        class="relative trigger-play flex justify-center items-center focus:outline-none focus-visible:ring focus-visible:ring-indigo-300 rounded-3xl group"
        @click="modalOpen = true"
        aria-controls="modal"
        aria-label="Watch the video"
    >
      <!-- Play icon -->
      <svg width="91" height="90" viewBox="0 0 91 90" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M45.4994 89.8351C39.4712 89.8351 33.6224 88.6541 28.1152 86.3245C22.7967 84.0749 18.0208 80.8555 13.9201 76.7548C9.81945 72.6541 6.59999 67.8782 4.35041 62.5597C2.02084 57.0525 0.839844 51.2037 0.839844 45.1755C0.839844 39.1473 2.02084 33.2986 4.35041 27.7913C6.59999 22.4729 9.81945 17.697 13.9201 13.5963C18.0208 9.49563 22.7967 6.27617 28.1152 4.02658C33.6224 1.69702 39.4719 0.516022 45.4994 0.516022C51.5268 0.516022 57.3763 1.69702 62.8836 4.02658C68.202 6.27617 72.9779 9.49563 77.0786 13.5963C81.1793 17.697 84.3987 22.4729 86.6483 27.7913C88.9779 33.2986 90.1589 39.1481 90.1589 45.1755C90.1589 51.203 88.9779 57.0525 86.6483 62.5597C84.3987 67.8782 81.1793 72.6541 77.0786 76.7548C72.9779 80.8555 68.202 84.0749 62.8836 86.3245C57.3763 88.6541 51.5268 89.8351 45.4994 89.8351ZM45.4994 5.80204C23.7889 5.80204 6.12586 23.4651 6.12586 45.1755C6.12586 66.886 23.7889 84.549 45.4994 84.549C67.2098 84.549 84.8729 66.886 84.8729 45.1755C84.8729 23.4651 67.2098 5.80204 45.4994 5.80204Z" fill="white"/>
        <path d="M36.3913 27.1918L65.4917 43.9931C66.3975 44.5162 66.3975 45.8233 65.4917 46.3464L36.3913 63.1477C35.4855 63.6708 34.3535 63.0173 34.3535 61.971V28.3685C34.3535 27.323 35.4855 26.6694 36.3913 27.1918Z" fill="white"/>
      </svg>
    </button>
    <!-- End: Video thumbnail -->

    <!-- Modal backdrop -->
    <div
        class="fixed inset-0 z-[99999] bg-black bg-opacity-50 transition-opacity"
        x-show="modalOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        aria-hidden="true"
        x-cloak
    ></div>
    <!-- End: Modal backdrop -->

    <!-- Modal dialog -->
    <div
        id="modal"
        class="fixed inset-0 z-[99999] flex p-6"
        role="dialog"
        aria-modal="true"
        x-show="modalOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-out duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        x-cloak
    >
        <div class="max-w-7xl w-full mx-auto h-full flex items-center">
            <div
                class="w-full max-h-full rounded-3xl shadow-2xl aspect-video bg-black overflow-hidden"
                @click.outside="modalOpen = false"
                @keydown.escape.window="modalOpen = false"
            >
                <!-- YouTube Embed -->
                 @if ('youtube' == $video_type)
                <div x-show="modalOpen" class="w-full h-full">
                    <iframe
                        class="w-full h-full"
                        src="https://www.youtube.com/embed/VIDEO_ID?autoplay=0"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        x-init="$watch('modalOpen', value => {
                            if (value) {
                                $el.src = $el.src.replace('autoplay=0', 'autoplay=1');
                            } else {
                                $el.src = $el.src.replace('autoplay=1', 'autoplay=0');
                            }
                        })"
                    ></iframe>
                </div>
                @else
                <!-- Uncomment for Vimeo instead -->

                <div x-show="modalOpen" class="w-full h-full">
                    <iframe
                        class="w-full h-full"
                        src="https://player.vimeo.com/video/894144179?autoplay=0"
                        title="Vimeo video player"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen
                        x-init="$watch('modalOpen', value => {
                            if (value) {
                                $el.src = $el.src.replace('autoplay=0', 'autoplay=1');
                            } else {
                                $el.src = $el.src.replace('autoplay=1', 'autoplay=0');
                            }
                        })"
                    ></iframe>
                </div>
                @endif

            </div>
        </div>
    </div>
    <!-- End: Modal dialog -->

</div>

<script>
// This script initializes the Alpine.js component for the video modal
// It handles the opening and closing of the modal, as well as the video playback
// This component handles the video modal functionality
document.addEventListener('alpine:init', () => {
    Alpine.data('videoController', () => ({
        modalOpen: false,

        init() {
            // Get reference to the video element
            const bgVideo = document.getElementById('bgVideo');

            // Add event listener to all elements with trigger-play class
            document.querySelectorAll('.trigger-play').forEach(trigger => {
                trigger.addEventListener('click', () => {
                  if (bgVideo) {
                      bgVideo.pause();
                  }

                  // Set modalOpen to true
                  this.modalOpen = true;
                });
            });

            // Optional: Resume video when modal is closed
            this.$watch('modalOpen', value => {
                if (!value && bgVideo) {
                    // If you want to auto-resume the video when modal is closed
                    // Uncomment the next line
                    bgVideo.play();
                }
            });
        }
    }));
});
</script>
