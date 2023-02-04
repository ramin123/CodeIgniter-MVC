$('#mix-wrapper').mixItUp({
  load: {
  	sort: 'order:asc'
  },
	animation: {
    effects: 'fade rotateZ(-180deg)',
    duration: 700
  },
  selectors: {
    target: '.mix-target',
    filter: '.filter-btn',
    sort: '.sort-btn'
  },
  callbacks: {
    onMixEnd: function(state){
      console.log(state)
    }
  }
});