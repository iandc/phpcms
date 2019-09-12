(function (lib, img, cjs, ss) {

var p; // shortcut to reference prototypes

// library properties:
lib.properties = {
	width: 640,
	height: 480,
	fps: 24,
	color: "#FFFFFF",
	manifest: [
		{src:"http://www.eetop.cn/adi/motion/images/bg.png", id:"bg"},
		{src:"http://www.eetop.cn/adi/motion/images/bg2.jpg", id:"bg2"},
		{src:"http://www.eetop.cn/adi/motion/images/txt1.png", id:"txt1"},
		{src:"http://www.eetop.cn/adi/motion/images/txt2.png", id:"txt2"},
		{src:"http://www.eetop.cn/adi/motion/images/txt3.png", id:"txt3"},
		{src:"http://www.eetop.cn/adi/motion/images/txt4.png", id:"txt4"}
	]
};



// symbols:



(lib.bg = function() {
	this.initialize(img.bg);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,621,135);


(lib.bg2 = function() {
	this.initialize(img.bg2);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,640,480);


(lib.txt1 = function() {
	this.initialize(img.txt1);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,117,27);


(lib.txt2 = function() {
	this.initialize(img.txt2);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,329,28);


(lib.txt3 = function() {
	this.initialize(img.txt3);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,329,28);


(lib.txt4 = function() {
	this.initialize(img.txt4);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,108,22);


(lib.mainButton = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("rgba(0,255,102,0.498)").s().p("A3bTiMAAAgnDMAu2AAAMAAAAnDg");
	this.shape.setTransform(150,125);
	this.shape._off = true;

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(3).to({_off:false},0).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = null;


(lib.Logo = function() {
	this.initialize();

	// 图层 3
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#FFFFFF").s().p("AbTINQgRgbgHghIgDgcIBnAAIABAOQACAQAIAOQAZAsBIAFQAjACAjgOQAygVAAgqQAAgvg2gSQhGgOgegJQhKgTgigUQhAgnAAhEQAAhJA4gvQA8gzBoAAQB6ABAwBMQAYAnAAAsIhkAAQgJghgKgNQgYgeg4gCQgoAAgdAOQgmARAAAiQAAAqAuATQAZALBOAMQBeASAnAgQAvAmgDBLQgCBJg5AvQg8AxheAAQiPAAg4hYgAN4IOQg+hQgGhyQgFh1A7hOQBChYB7ABQB6AABBBUQAYAgAYBGIhrAAQgTgjgZgbQgkglgjgCQhEgFgoA8QgkA2AABRQAABRAkA5QAoA/BEAAQA6AAAigvQARgYAJgeIBpAAQgEAugfAuQg+BdiMABIgFAAQhmAAhDhVgEghuAJjIAAy6IS2AAIAAS6gA93HKIL0m9Ir0mngAkDJXIAAodIGMAAIAABaIkfAAIAAB0ID+AAIAABiIj9AAIAACRIEoAAIAABcgAUmJWIAAocIGAAAIAABiIkYAAIAABvID4AAIAABhIj3AAIAACOIEkAAIAABcgArzJWIAAocIDRAAQBxAABFBRQBBBOAAB4QABB5g+BFQhBBHh6AAgAqBICIBcAAQBRAAAig9QAZgtgChMQAAg/gegzQgnhEhMAAIhVAAgAKVJVIAAoaIBzAAIAAIagAFfJVIiyn+IAAgcIBtAAIB5GLIB3mKIBqAAIAAAcIivH9gAdgg2Qh2gDhEhWQg+hPABhvQAChvBBhOQBIhWB7gDQA6AAA3AfQAsAaAYAhQAfAqAFAuIhcAAQgZgpgTgQQgjghgyAAQhHgBgsA7QgoA2gBBNQgCBOAnA2QArA8BLABQA7ACAwgxQAXgZAMgZIAAgcIiBAAIAAhUIDeAAIAAESIhVAAIAAg0QgWAYgaASQgxAgg6AAIgFAAgASNiNQhAhPAChyQAChyBBhOQBIhXB4ABQB0ABBFBYQA/BPAABwQABByg/BNQhFBXh5AAQh7AAhGhXgATgnOQgmA1gBBNQgBBMAkA1QAoA7BGAAQBHABAqg7QAlg0ABhMQAAhMglg2Qgog7hGgBIgBAAQhEAAgpA6gAL3g+IAAoeIBsAAIAAHCIDyAAIAABcgAJyg/Igqh4IjGAAIglB4IhsAAIC2odIBuAAIDMIdgAGdkhIAAAeICMAAQgDgXgCgHIhDjMgABxg/IjrluIAAFuIhtAAIAAodIBvAAIDjFpIAAlpIBtAAIAAIdgAlqg/Igqh4IjGAAIglB4IhsAAIC2odIBuAAIDMIdgAo6kkIgEAiICGAAIAAgUIgBgNIhEjHg");
	this.shape.setTransform(61.3,15.8,0.326,0.326);

	this.addChild(this.shape);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-9.2,-4.2,141,40.1);


(lib.Icon = function() {
	this.initialize();

	// 图层 2
	this.instance = new lib.bg();
	this.instance.setTransform(20.5,217.5);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(20.5,217.5,621,135);


(lib.HL4 = function() {
	this.initialize();

	// 图层 2
	this.instance = new lib.txt3();

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,329,28);


(lib.HL2 = function() {
	this.initialize();

	// 图层 2
	this.instance = new lib.txt2();

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,329,28);


(lib.HL1 = function() {
	this.initialize();

	// 图层 2
	this.instance = new lib.txt1();
	this.instance.setTransform(0,20);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,20,117,27);


(lib.CTA = function() {
	this.initialize();

	// 图层 2
	this.instance = new lib.txt4();
	this.instance.setTransform(2,0,0.64,0.64);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(2,0,69.1,14.1);


// stage content:
(lib._15958_ADI_CorpMotion_V1_DBA_640x480 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// timeline functions:
	this.frame_0 = function() {
		//turns mouse pointer into hand
		this.btn_main.cursor = "pointer";
	}
	this.frame_266 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(266).call(this.frame_266).wait(1));

	// button
	this.btn_main = new lib.mainButton();
	this.btn_main.setTransform(0,0,2.133,1.92);
	new cjs.ButtonHelper(this.btn_main, 0, 1, 2, false, new lib.mainButton(), 3);

	this.timeline.addTween(cjs.Tween.get(this.btn_main).wait(267));

	// border
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#888888").ss(1,2,0,3).p("Egx/glfMBj/AAAMAAABK/Mhj/AAAg");
	this.shape.setTransform(320,240);

	this.timeline.addTween(cjs.Tween.get(this.shape).wait(267));

	// CTA
	this.instance = new lib.CTA();
	this.instance.setTransform(341,541.6,1,1,0,0,0,150,125);
	this.instance.alpha = 0;
	this.instance._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(245).to({_off:false},0).to({alpha:1},11).wait(11));

	// HLmask (mask)
	var mask = new cjs.Shape();
	mask._off = true;
	var mask_graphics_52 = new cjs.Graphics().p("EgZkAkTIAAy6MBK5AAAIAAS6g");

	this.timeline.addTween(cjs.Tween.get(mask).to({graphics:null,x:0,y:0}).wait(52).to({graphics:mask_graphics_52,x:315.7,y:232.3}).wait(215));

	// HL4
	this.instance_1 = new lib.HL4();
	this.instance_1.setTransform(780,512.6,1,1,0,0,0,150,125);
	this.instance_1._off = true;

	this.instance_1.mask = mask;

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(192).to({_off:false},0).to({x:342},12,cjs.Ease.get(1)).wait(32).to({y:502.6},10,cjs.Ease.get(1)).wait(21));

	// HL2
	this.instance_2 = new lib.HL2();
	this.instance_2.setTransform(782,514,1,1,0,0,0,150,125);
	this.instance_2._off = true;

	this.instance_2.mask = mask;

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(124).to({_off:false},0).to({x:342},12,cjs.Ease.get(1)).wait(43).to({x:-29},13,cjs.Ease.get(-1)).wait(75));

	// HL1
	this.instance_3 = new lib.HL1();
	this.instance_3.setTransform(780,493,1,1,0,0,0,150,125);
	this.instance_3._off = true;

	this.instance_3.mask = mask;

	this.timeline.addTween(cjs.Tween.get(this.instance_3).wait(52).to({_off:false},0).to({x:342},12,cjs.Ease.get(1)).wait(47).to({x:22},13,cjs.Ease.get(-1)).wait(143));

	// Icon copy
	this.instance_4 = new lib.Icon();
	this.instance_4.setTransform(140,243,1,1,0,0,0,150,125);
	this.instance_4.alpha = 0;
	this.instance_4._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_4).wait(17).to({_off:false},0).to({alpha:1},11).wait(239));

	// Logo
	this.instance_5 = new lib.Logo();
	this.instance_5.setTransform(331.6,71,1.001,1,0,0,0,77.3,32.3);

	this.timeline.addTween(cjs.Tween.get(this.instance_5).wait(267));

	// BG
	this.instance_6 = new lib.bg2();

	this.timeline.addTween(cjs.Tween.get(this.instance_6).wait(267));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(319,239,642,482);

})(lib = lib||{}, images = images||{}, createjs = createjs||{}, ss = ss||{});
var lib, images, createjs, ss;