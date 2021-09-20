let dropEvents = ["dragover", "drop"];
dropEvents.forEach((listened) => {
  window.addEventListener(
    listened,
    function (e) {
      e.preventDefault();
    },
    false
  );
});

/**
 * Video drop
 */
let dropZone = document.querySelector("#file-upload1");
let input = document.querySelector("#post_videoFile_file");
dropZone.addEventListener(
  "drop",
  (e) => {
    e.preventDefault();
    let file = e.dataTransfer.files[0];
    $("#file-upload1").addClass("is-dragover");
    input.files = e.dataTransfer.files;
    dropZone.innerHTML += `<h4 style='pointer-events: none;'>Vidéo : ${
      file.name
    } (${(file.size / 1000000).toFixed(2)} Mo)</h4>`;
  },
  false
);

/**
 * Image drop
 */
let dropZone2 = document.querySelector("#file-upload2");
let input2 = document.querySelector("#post_imageFile_file");
dropZone2.addEventListener(
  "drop",
  (e) => {
    e.preventDefault();
    let file2 = e.dataTransfer.files[0];
    $("#file-upload2").addClass("is-dragover");
    input2.files = e.dataTransfer.files;
    dropZone2.innerHTML += `<h4 style='pointer-events: none;'>Image : ${
      file2.name
    } (${(file2.size / 1000000).toFixed(2)} Mo)</h4>`;
  },
  false
);
