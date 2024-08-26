/*gestion défilement backgrounds*****************************************************************************/

window.addEventListener('scroll', function() {
    const scrollValue = window.scrollY;
  
    // Adjust scroll speed for each image
    document.querySelector('.background-image-left-1').style.transform = `translateY(${scrollValue * -0.2}px)`;
    document.querySelector('.background-image-left-2').style.transform = `translateY(${scrollValue * -0.4}px)`;
    document.querySelector('.background-image-right-1').style.transform = `translateY(${scrollValue * -0.3}px)`;
    document.querySelector('.background-image-right-2').style.transform = `translateY(${scrollValue * -0.5}px)`;
});
  