$(function() { 
   //套件
   
   TweenMax.fromTo(".classname", 0.5, {
    x: -20,
    opacity: 0,
}, {
    x: 0,
    opacity: 1,
    delay: 1,
    ease: SteppedEase.easeNone,
    // repeat: 2,
    // repeatDelay: 1
});


   TweenMax.fromTo(".classname2", 0.5, {
    x: -10,
    opacity: 0,
}, {
    x:0,
    opacity: 1,
    delay: 2,
    ease: Linear.easeNone,
    // repeat: 2,
    // repeatDelay: 1
});
console.log('animations ok');
   
//   TweenMax.fromTo("hi", 1, {rotation:360,repeat:-1});    
    
  TweenMax.fromTo('.class',0.5,{
      x:-10,
      opacity:0,
  },{
      x:0,
      opacity:1,
      delay:2,
      ease:Linear.easeNone, 

  }); 
   
   
   
   
   });