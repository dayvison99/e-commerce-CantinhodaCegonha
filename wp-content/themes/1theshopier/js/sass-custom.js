var sass = new Sass();
console.log(0);
sass.writeFile('testfile.scss', '.deeptest { content: "loaded"; }', function() {
  console.log('wrote "sub/deeptest.scss"');
});
sass.options({ style: Sass.style.expanded }, function(result) {
  console.log("set options");
});
sass.compile('@import "testfile";', function(result) {
  console.log("compiled", result.text);
});