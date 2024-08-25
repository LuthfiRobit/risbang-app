 <script>
     document.addEventListener('DOMContentLoaded', () => {
         // URL to fetch data from
         const dataUrl = '{{ route('landpage.pengumuman.list.utama') }}'; // Replace with the appropriate URL

         // Function to format date with time
         const formatDateTime = (dateString) => {
             const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                 'September', 'Oktober', 'November', 'Desember'
             ];
             const date = new Date(dateString);
             const day = date.getUTCDate();
             const month = months[date.getUTCMonth()];
             const year = date.getUTCFullYear();
             const hours = date.getUTCHours().toString().padStart(2, '0');
             const minutes = date.getUTCMinutes().toString().padStart(2, '0');
             return `${day} ${month} ${year} ${hours}:${minutes}`;
         };

         // Function to generate HTML for a timeline item
         const createTimelineItemHtml = (item, type) => {
             const dateTime = formatDateTime(item.created_at);
             const isAnnouncement = type === 'pengumuman';
             const colorClass = isAnnouncement ? 'primary' : 'danger';
             const fileLabel = isAnnouncement ? 'Download Berkas Pengumuman' : 'Download Berkas Pedoman';
             const fileUrl = item.url || `{{ asset('files/pengumuman/') }}/${item.file_pengumuman}`;
             const itemType = isAnnouncement ? 'Pengumuman' : 'Pedoman';

             return `
            <div class="timeline-items mb-3 border-${colorClass} rounded border border-dashed pt-3">
                <div class="timeline-item">
                    <div class="timeline-media m-3">
                        <span><i class="bi bi-info-circle text-${colorClass} fs-1"></i></span>
                    </div>
                    <div class="timeline-content">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="mr-2">
                                <a href="#" class="text-${colorClass} text-hover-${colorClass} fw-bolder">${itemType}</a>
                                <span class="text-muted ml-2"> | ${dateTime}</span>
                            </div>
                        </div>
                        <div class="row">
                            <span class="fs-12 text-gray-700 fw-bolder">${item.judul}</span>
                            <div class="row">
                                <a href="${fileUrl}" target="_blank" class="d-flex align-items-center text-${colorClass} text-hover-success me-5 mb-2">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <i class="bi bi-download"></i>
                                    </span>
                                    ${fileLabel}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
         };

         // Function to render timeline items into a container
         const renderTimeline = (data, type) => {
             const container = document.querySelector(`#timeline-${type.toLowerCase()}`);
             const items = data[type.toLowerCase()] || []; // Default to empty array if not found
             container.innerHTML = items.length > 0 ?
                 items.map(item => createTimelineItemHtml(item, type.toLowerCase())).join('') :
                 '<p>No data available.</p>';
         };

         // Fetch data and populate timeline sections
         const fetchDataAndPopulateTimelines = () => {
             fetch(dataUrl)
                 .then(response => {
                     if (!response.ok) throw new Error('Network response was not ok');
                     return response.json();
                 })
                 .then(data => {
                     if (data?.success) {
                         renderTimeline(data, 'Pengumuman');
                         renderTimeline(data, 'Pedoman');
                     } else {
                         console.error('Failed to fetch valid data:', data);
                     }
                 })
                 .catch(error => console.error('Error fetching data:', error));
         };

         // Initialize the data fetch and rendering
         fetchDataAndPopulateTimelines();
     });
 </script>
