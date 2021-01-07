/*(function(){
  window['is_scrolled'] = false;
  window.onload = function(){
    var topheader = document.getElementById('top-header');
    console.log(topheader);
    window.onscroll = function(){
      var y = window.pageYOffset || document.documentElement.scrollTop;
      if(y>10){
        window['is_scrolled'] = true;
        topheader.className = 'scrolled';
      } else {
        if(window['is_scrolled'] == true){
          window['is_scrolled'] = false;
          topheader.className = '';
        }
      }
    }
  }
})();*/

//(function(){

  if (!String.prototype.trim) {
      (function() {
          // Make sure we trim BOM and NBSP
          var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
          String.prototype.trim = function() {
              return this.replace(rtrim, '');
          };
      })();
  }

  if (!String.prototype.appendStyle) {
      (function() {
          String.prototype.appendStyle = function(style) {
            var list = this.split(' ');
            if(list.indexOf(style) == -1){
              return this.replace('','')+' '+style;
            } else {
              return this.replace('','');
            }
          };
      })();
  }

  window.onresize = function(){
    z.sliderWidthFix();
  };

  window.addEventListener('popstate', function(event) {
    if(!event.state) return;
    if(typeof(window['z'])!='undefined' && window['z']!=null){

      if(event.state.hasOwnProperty('mode')){
        if(event.state.mode=='catalog'){
          z.catalogFilterProccess(event.state.url, '', true);
        }
      } else {
        //usual ajax
      }
    }
  }, false);

  window.onload = function(){

    var cart_holder = document.getElementById('cart_holder'),
        cart_box = document.getElementById('cart_box'),
        cart_box_hovered = false;

    if(typeof(cart_box)!='undefined' && cart_box!=null){
      var hideCartBox = function(){
        
        cart_box_hovered = false;
        setTimeout(function(){
          if(cart_box_hovered == false){
            cart_box_hovered = false;
            cart_holder.style.display = 'none';
          }
        }, 800);

      };    

      cart_box.onmouseover = function(){
        cart_box_hovered = true;
        cart_holder.style.display = 'block';
      };
      cart_box.onmouseout = hideCartBox;
      cart_holder.onmouseover = function(){
        cart_box_hovered = true;
        cart_holder.style.display = 'block';
      };
      cart_holder.onmouseout = hideCartBox;
    }

    //only auth e & f

    var amw = document.getElementById('auth-modal-wrapper');
    if(typeof(amw) != 'undefined' && amw != null){
      amw.onclick = function(e) {
        if(e.target == amw || e.target == document.getElementById('auth_modal_close')) {
          amw.style.display = 'none';
        }
      }
    }




    
    var body = document.getElementsByTagName('body')[0];
    body.addEventListener('click', function(e){

      //phone_country switcher ?:L)
      if(z.lastControlElement != null){
        if(e.target != z.lastControlElement.parentNode.getElementsByClassName('selected_phone_code')[0] && e.target.parentNode != z.lastControlElement.parentNode.getElementsByClassName('selected_phone_code')[0]){
          
          var changeValue = function(el){
            var li_id = el.getAttribute('data-id'),
                li_c = el.getAttribute('data-code'),
                p = el.parentNode,
                pp = p.parentNode,
                flag = el.getElementsByTagName('i')[0].className,
                phone_code_input = pp.getElementsByClassName('phone_code_input')[0],
                spc = pp.getElementsByClassName('selected_phone_code')[0],
                phone_code = spc.getElementsByClassName('phone_code')[0];
            phone_code_input.value = li_id;
            phone_code.innerHTML = li_c;
            spc.getElementsByTagName('i')[0].className = 'flag '+flag;
            p.className += ' hidden';
            //console.log(pp.parentNode.getElementsByClassName('phone_input')[0]);
            //setTimeout(function(){
              pp.parentNode.getElementsByClassName('phone_input')[0].focus();
            //}, 500);
          };

          if(e.target.tagName.toLowerCase() == 'li'){
            changeValue(e.target);
          } else if(e.target.parentNode.tagName.toLowerCase() == 'li'){
            changeValue(e.target.parentNode); 
          } else if(e.target.parentNode != z.lastControlElement && e.target.parentNode.parentNode != z.lastControlElement){
            z.lastControlElement.className = z.lastControlElement.className.appendStyle('hidden');
          }
        }
      } else if(document.getElementById('product-gallery-wrapper').style.display == 'block'){
        if(
          e.target.className.split('tns-lazy-img').length<2 &&
          e.target.className.split('img-gallery').length<2 &&
          e.target.className.split('zoomed-image').length<2 &&
         e.target.className.split('slidetns').length<2 && 
         e.target.className.split('close').length<2
        ){
          z.sliders['zuvi-gallery-slider'].destroy();
          document.getElementById('product-gallery-wrapper').style.display = 'none';
        }
        //zuvi-gallery-slider_wrapper
      }

    });

    z.initEvents();

  };

  window.$ = new function(){
    return new function(q){

      this.isset = function(el){
        if(typeof(el)!='undefined'&&el!=null){
          return true;
        } else {
          return false;
        }
      };

      this.toggleClass = function(p, name){
        if(p.className.split(name).length>1){
          p.className = p.className.replace(name, '').trim();
        } else {
          p.className = p.className.appendStyle(name);
        }
      };

      this.ajax = function xhr(type, data, callback, json){
        if(!json) json = false;
        var xhr = new XMLHttpRequest();
        if(type == "post"){
          xhr.open(type, '/api', true);
          xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        } else {
          xhr.open(type, '/api?'+data, true);
        }
        xhr.onload = function(){
          if(xhr.readyState === 4){
            if(xhr.status == 200){
              if(json){
                callback(JSON.parse(xhr.responseText));
              } else {
                callback(xhr.responseText);
              }
            }
          }
        };
        xhr.send();
      };

      this.remove = function(el){
        console.log('remove');
          return el.parentNode.removeChild(el);
      };

      this.validateEmail = function(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      };

      this.validateInput = function(input){
              if(z.lastInputTimer) return false;
            z.lastInputTimer = true;
            setTimeout(function(){
              if(z.lastInputTimer!=null){
        var p = input.parentNode;
          var type = input.getAttribute('data-type');
          var err = p.getElementsByClassName('err');
          var is_err = err.length>0 ? true : false;
          if(is_err){
            if(type == 'first_name' || type == 'last_name'){
              if(input.value!='' && is_err){
                $.remove(err[0]);
              }
            } else if(type == 'email'){
              if(input.value!='' && $.validateEmail(input.value)){
                $.remove(err[0]);
              }
            } else if(type == 'password'){
              if(input.value!='' && input.value.length>5){
                $.remove(err[0]);
              }
            }
          }
          z.lastInputTimer = null;
        }
            }, 700);
          return false;
      };

      this.addError = function(el, name){
            var div = document.createElement("div");
div.className = "err";
div.innerHTML = z.errors[name];
el.parentNode.appendChild(div);
z.lastInputTimer = null;
      };

    }
  }

  window.z = new function(){
    return new function(q){
      this.doc = document;

      this.currentUrl = '';

      this.sliders = new Object();
      this.lastControlElement = null;
      this.lastInputTimer = null;
      this.vkWindow = null;
      this.productImages = [1,2,3,4,5,6,7];
      this.priceSlider = null;
      this.priceSliderStep = null;

      this.errors = {
        'first_name': 'Имя не может быть пустым.',
        'last_name': 'Фамилия не может быть пустой.',
        'email': 'E-mail введен неверно.',
        'email_is_registered': 'E-mail уже зарегистрирован.',
        'password': 'Не менее 6 символов',
        'user_not_found': 'Пользователь не найден',
        'wrong_password': 'Неверный логин или пароль'
      };

      this.initEvents = function(){

        var body = document.getElementsByTagName('body')[0];

        var cbs = body.getElementsByClassName('checkbox-wrapper');
        if(cbs.length>0){
          for(var i=0;i<cbs.length;++i){
            cbs[i].onclick = function(e){
              var cw;
              if(e.target.className=='checkbox' || e.target.tagName.toLowerCase()=='span'){
                cw = e.target.parentNode;
              } else {
                cw = e.target;
              }
              if(cw.className.split('checked').length==2){
                cw.className = cw.className.replace('checked', '').trim();
              } else {
                cw.className = cw.className.appendStyle('checked');
              }
            };
          }
        }

        var searchclose = document.getElementById('search-close');
        if(typeof(searchclose)!='undefined'&&searchclose!=null){
        searchclose.addEventListener('click', function(){
          var sw = document.getElementById('search-wrapper'),
              s = document.getElementById('search');
          s.value = '';
          sw.style.display = 'none';
        });
        }

  z.sliderWidthFix();


var sliderOptions = {
  'zuvi-slider': {
    "container": "",
    "items": 2,
    "lazyload": true,
    "arrowKeys": true,
    "mouseDrag": true,
    //"controlsContainer": "#customize-controls",
    "navContainer": "#customize-thumbnails",
    "navAsThumbnails": true,
    //"slideBy": "page",
    "animateIn": "jello",
    "animateOut": "jello",
    //"fixedWidth": www,
    "swipeAngle": false,
    "speed": 250
  }
};



for (var i in sliderOptions) {
  var item = sliderOptions[i];
  item.container = '#' + i;
  if (!item.speed) { item.speed = speed; }
  
  if (this.doc.querySelector(item.container)) {
    this.sliders[i] = tns(sliderOptions[i]);

  // test responsive pages
  }
}

        var detailnav = this.doc.getElementsByClassName('info-head');
        if(detailnav.length>0){
          for(var i=0;i<detailnav.length;++i){
            detailnav[i].onclick = function(){
              var p = this.parentNode;
              if(p.className.split('switched').length>1){
                p.className = p.className.replace('switched').trim();
              } else {
                p.className = p.className.appendStyle('switched');
              }
            };
          }
        }





        z.catalogEvents();


        var sliderInput = document.getElementById('price-slider-inner');
        if($.isset(sliderInput)){
          
        var minPrice = parseInt(sliderInput.getAttribute('data-from')),
            maxPrice = parseInt(sliderInput.getAttribute('data-to')),
            selectedMinPrice = sliderInput.getAttribute('data-price-from'),
            selectedMaxPrice = sliderInput.getAttribute('data-price-to');
        var sliderMinPrice = minPrice,
            sliderMaxPrice = maxPrice;
        if(selectedMinPrice>0&&selectedMaxPrice>0){
          sliderMinPrice = parseInt(selectedMinPrice);
          sliderMaxPrice = parseInt(selectedMaxPrice);
        }
        var stepPrice = parseInt(maxPrice/minPrice/2);
        if(minPrice && maxPrice){
          this.priceSliderStep = stepPrice>15?stepPrice:15;
          //selectedMinPrice = this.priceSliderStep;
                this.priceSlider = new rSlider({
                    target: '#price-slider-inner',
                    values: {min: minPrice, max: maxPrice},
                    step: this.priceSliderStep,
                    range: true,
                    set: [sliderMinPrice, sliderMaxPrice],
                    scale: true,
                    labels: false,
                    tooltip: false,
                    onChange: function (vals) {
                      console.log('price vals', vals);
                    }
                });
          var closest = function(num, arr) {
                var mid;
                var lo = 0;
                var hi = arr.length - 1;
                while (hi - lo > 1) {
                    mid = Math.floor ((lo + hi) / 2);
                    if (arr[mid] < num) {
                        lo = mid;
                    } else {
                        hi = mid;
                    }
                }
                if (num - arr[lo] <= arr[hi] - num) {
                    return arr[lo];
                }
                return arr[hi];
            }
            console.log(closest(sliderMinPrice, this.priceSlider.conf.values));
            this.priceSlider.setValues(closest(sliderMinPrice, this.priceSlider.conf.values), closest(sliderMaxPrice, this.priceSlider.conf.values))
        }


      }


      };

      this.catalogEvents = function(){
        var productsList = document.getElementById('products-list');
        if(typeof(productsList)!='undefined' && productsList!=null){
          var productsListItems = productsList.getElementsByTagName('li');
          for(var i=0;i<productsListItems.length;++i){
            productsListItems[i].onmouseover = function(ev){
              var et = ev.target;
              while(et.tagName.toLowerCase()!='li'){
                et = et.parentNode;
              }
              if(et.getAttribute('data-overshow')=='1'){
                et.className = et.className.appendStyle('overshow');
              }
              var lazyimgs = et.getElementsByClassName('image-list')[0].getElementsByTagName('img');
              for(var i=0;i<lazyimgs.length;++i){
                if(lazyimgs[i].className.split('lazy-loaded').length<=1){
                  var ts = lazyimgs[i].getAttribute('data-src');
                  lazyimgs[i].src = ts;
                  lazyimgs[i].removeAttribute('data-src');
                  lazyimgs[i].className += ' lazy-loaded';
                }
              }

            };
            productsListItems[i].onmouseout = function(ev){
              var et = ev.target;
              while(et.tagName.toLowerCase()!='li'){
                et = et.parentNode;
              }
              if(et.className.split('overshow').length>1)
                et.className = et.className.replace('overshow', '').trim();
              
            };
          }
        }
      };

      this.showProductGallery = function(id){
        var w = document.getElementById('product-gallery-wrapper');
        w.style.display = 'block';
        var width = parseInt(w.clientWidth);
        var height = parseInt(w.clientHeight);
        width = width-width*5/100;
        height = height-height*10/100;
        var tpl = '<div id="zuvi-gallery-slider_wrapper" class="vanilla-zoom" style="width: '+width+'px;height: '+height+'px;margin-left: -'+width/2+'px;margin-top: -'+height/2+'px"><div class="mouse-drag" id="zuvi-gallery-slider">';
        var imgs = this.productImages;
        for(var i=0;i<imgs.length;++i){
          tpl += '<div>';
          tpl += '<div class="image-slide-wrapper" style="height: '+height+'px;line-height: '+height+'px;">';
          tpl += '<img src="/st/images/slider/'+imgs[i]+'.jpg" class="img-gallery small-preview" />';
          tpl += '</div>';
          tpl += '</div>';
        }
        tpl += '</div></div>';
        //<div id="gallery-close"></div>
        w.innerHTML = tpl;



var sliderOptions = {
  'zuvi-gallery-slider': {
    "container": "",
    "items": 1,
   // "lazyload": true,
    "arrowKeys": true,
    //"controlsContainer": "#customize-controls",
    //"slideBy": "page",
    "animateIn": "jello",
    "animateOut": "jello",
    //"fixedWidth": www,
    "swipeAngle": false,
    "speed": 250
  }
};



for (var i in sliderOptions) {
  var item = sliderOptions[i];
  item.container = '#' + i;
  if (!item.speed) { item.speed = speed; }
  
  if (this.doc.querySelector(item.container)) {
    this.sliders[i] = tns(sliderOptions[i]);

  // test responsive pages
  }
}
vanillaZoom.init('#zuvi-gallery-slider');
this.sliders['zuvi-gallery-slider'].goTo(id);

        

      };

      this.addToCart = function(el){
        this.catPreloader(el, 38, 32);
        var imgs = document.getElementById('customize-thumbnails').getElementsByTagName('li');
        if(imgs.length>0){
          var parentForImage = document.getElementsByTagName('body')[0];
          var img = imgs[0].getElementsByTagName('img')[0];
          var topOffset = parseInt(img.getBoundingClientRect().top+window.scrollY);
          var leftOffset = parseInt(img.getBoundingClientRect().left);
          var imageSrc = img.src;
          var imageWidth = img.clientWidth;
          var imageHeight = img.clientHeight;
          var newEl = document.createElement('img');
          newEl.className = 'cart-image';
          newEl.style.width = imageWidth+'px';
          newEl.style.height = imageHeight+'px';
          newEl.style.top = topOffset+'px';
          newEl.style.left = leftOffset+'px';
          newEl.src = imageSrc;
          parentForImage.appendChild(newEl);


          var cart_box = document.getElementById('cart_box');
          var topOffset2 = parseInt(cart_box.getBoundingClientRect().top+window.scrollY);
          var leftOffset2 = parseInt(cart_box.getBoundingClientRect().left);

          var new_to = topOffset2,
              new_lo = leftOffset,
              new_w = imageWidth,
              new_h = imageHeight;
          var animation = function(){
            console.log(new_lo, leftOffset);
            if(new_to < topOffset){
              new_to--;
              newEl.style.top = new_to+'px';
            }
            if(new_lo < leftOffset2){
              new_lo = new_lo+parseInt(new_lo/new_to);
              newEl.style.left = new_lo+'px';
            }
            new_w--;
            new_w = new_w-parseInt(imageWidth/20);
            new_h--;
            new_h = new_h-parseInt(imageHeight/40);
            newEl.style.width = new_w+'px';
            newEl.style.height = new_h+'px';
            if(topOffset >= new_to && new_lo >= leftOffset2){
              parentForImage.removeChild(newEl);
              clearInterval(animate);
            }

          };
          var animate = setInterval(animation, 20);
          var cart_box = document.getElementById('cart_box').getElementsByTagName('a')[0];
          setTimeout(function(){
            cart_box.className += ' added';
          }, 200);
          setTimeout(function(){
            cart_box.className = cart_box.className.replace('added', '').trim();
          }, 1000);

          el.innerHTML = 'Добавить в корзину';

          console.log(topOffset, leftOffset, topOffset2, leftOffset2)
        }
      };

      this.toggleFilterBox = function(el){
        if(el.parentNode.className.split('pricehidden').length>1){
/*          var psw = document.getElementById('price-slider-wrapper').getElementsByClassName('rs-container')[0];
          if(typeof(psw)!='undefined' && psw!=null){
            //var self = this;

            this.priceSlider.move(99);

            console.log('init123sed');
          }*/
          $.toggleClass(el.parentNode, 'pricehidden');
        } else {
          $.toggleClass(el.parentNode, 'toggled');
        }
      };

      this.catPreloader = function(el, w, h){
        el.innerHTML = '<img src="/st/images/loader2.png" style="height: '+h+'px; width: '+w+'px; image-rendering: optimizequality; position: absolute; top: 50%; left: 50%; margin: -16px 0px 0px -16px; z-index: 5;" />';
      };

      this.sliderWidthFix = function(){
        var mc = document.getElementById('media-content');
        if(typeof(mc)!='undefined'&&mc!=null){
          var www = parseInt(mc.clientWidth);
          var www2 = document.getElementById('zuvi-slider_wrapper');
          var www3 = document.getElementById('item-gallery-previews');
          var offval = (parseInt(www-(www*22/100))-5);
          www2.style.width = (offval%2==0 ? offval : offval-1)+'px';
          www3.style.width = parseInt(www*20/100)+'px';
        }
      };

      this.clearFilters = function(){
        var cur = this.currentUrl;
        var qs = cur.split('?');
        qs = qs.length>1?'?'+qs[1]:'';
        var fi = cur.split('/by')[0]+qs;
        this.catalogFilterProccess(fi, '');
      };

      this.sortCatalog = function(el){
        var fi = z.currentUrl.split('?');
        console.log(fi);
        if(fi.length>1){
          var fa = fi[1].split('&');
          var na = [];
          for(var i=i;i<fa.length;++i){
            var ns = fa[i].split('=');
            if(ns[0]=='page'){
              na.push('page='+ns[1]);
            } else {
              if(el.value != 'new'){
                na.push('sort='+el.value);
              }
            }
          }
          if(el.value != 'new' && na.length==0){
            na.push('sort='+el.value);
          }
          fi = fi[0]+(na.length>0?'?'+na.join('&'):'');
        } else {
          fi = fi[0]+(el.value != 'new' ? '?sort='+el.value : '');
        }
        
        this.catalogFilterProccess(fi, 'sort');

      };

      this.catalogFilter = function(el){

/*        var minPrice = document.getElementById('price-slider-from').value,
            maxPrice = document.getElementById('price-slider-from').value;*/
        var href = el.getAttribute('href');
        if(!href) return false;

        this.catalogFilterProccess(href, '');

        return false;

      };

      this.catalogFilterProccess = function(href, mode, update_history = false){
        var api_url = 'req=catalog_filter&filter_url='+encodeURIComponent(href);
        $.ajax('get', api_url, function(data){

          z.currentUrl = data.current_url;

          var ddd = document.getElementById('remove-filters');
          if(data.option_ids_count == 0){
            ddd.style.display = 'none';
          } else {
            ddd.style.display = 'block';
          }

          if(mode=='sort' || update_history){
            history.replaceState({url: data.current_url, 'mode': 'catalog'}, "", data.current_url);
          } else {
            history.pushState({url: data.current_url, 'mode': 'catalog'}, "", data.current_url);
          } 

          //console.log(data)

          var products_view = document.getElementById('products-view');

          if(mode == ''){
            var ibc = document.getElementById("item-breadcrumbs")
            ibc.innerHTML = data.breadcrumbs;
          }


          if(mode == ''){
            var filters_view_list = document.getElementById('filters-view').getElementsByTagName('li');
            for(var i=0;i<filters_view_list.length;++i){

              var id = filters_view_list[i].getAttribute('data-id');

              if(id){

                if(data.option_link_ids.hasOwnProperty(id)){

                  if(filters_view_list[i].className.split('disabled').length < 1){

                    filters_view_list[i].className = filters_view_list[i].className.appendStyle('disabled').trim();

                  }

                  filters_view_list[i].className = filters_view_list[i].className.replace('disabled', '').trim();

                  if(data.option_link_ids[id]['active'] == true){

                    filters_view_list[i].className = filters_view_list[i].className.appendStyle('active');

                  } else {

                    if(filters_view_list[i].className.split('active').length > 1){

                      filters_view_list[i].className = filters_view_list[i].className.replace('active', '').trim();

                    }

                  }

                  filters_view_list[i].getElementsByTagName('a')[0].setAttribute('href', data.option_link_ids[id]['link']);
                  filters_view_list[i].getElementsByTagName('span')[0].innerHTML = data.option_link_ids[id]['count'];

                } else {

                  filters_view_list[i].getElementsByTagName('a')[0].removeAttribute('href');

                  filters_view_list[i].className = filters_view_list[i].className.appendStyle('disabled').trim();

                }

              }

              //console.log(filters_view_list[i].innerHTML);
            }
          }

          products_view.innerHTML = data.products_view;
          var myLazyLoad = new LazyLoad({
              elements_selector: ".lazy"
          });

          z.catalogEvents();

        }, true);
      };

      this.updateCatalogState = function(currentUrl){
        z.currentUrl = currentUrl;
        history.replaceState({url: currentUrl, 'mode': 'catalog'}, "", currentUrl);
        var myLazyLoad = new LazyLoad({
            elements_selector: ".lazy"
        });
      };

      this.go = function(el){
        var href = el.getAttribute('href');
        console.log(href);
        return false;
      };

      this.logout = function(){
        $.ajax('get', 'req=logout', function(){
          window.location.reload();
        });
      };

      this.search = function(){
        //send search request

        return false;
      };

      this.showSearch = function(){
        var w = document.getElementById('search-wrapper');
        w.style.display = 'block';
        var s = document.getElementById('search');
        s.focus();
      };

      this.vkAuthOk = function(){
        this.vkWindow.close();
        window.location.reload();
      };

      this.authVk = function(){

        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var w = 640;
        var h = 640;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        this.vkWindow = window.open('/api?req=vk-auth-url', 'Войти через VK', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        if (window.focus) {
            this.vkWindow.focus();
        }


      };

      this.phoneMaskEvent = function (e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        e.target.value = (!x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '')+ (x[4] ? '-' + x[4] : ''));
      };

      this.showAuthModal = function(){

        var email = document.getElementById('login-email').value,
          password = document.getElementById('login-password').value,
          $popup = document.getElementById('login-popup');

        if(email && password){
          $.remove("login-error");
          if(password.length<6){

            $popup.innerHTML += '<div id="login-error">Password contain <6 characters</div>';

            setTimeout(function(){
              $.remove("login-error");
            }, 2500);

          } else {

            $.get("/ajax.php?action=sign-in&email="+email+'&password='+password, function(data){

              if(data=='ok'){

                window.location.href = '/';

              } else {

                $popup.innerHTML += '<div id="login-error">'+data+'</div>';
                setTimeout(function(){
                  $.remove("login-error");
                }, 3500);

              }

            });
          }
        } else {
          $popup.innerHTML += '<div id="login-error">Please enter E-mail and Password</div>';
          setTimeout(function(){
            $.remove("login-error");
          }, 2500);
        }

/*        var amw = document.getElementById('auth-modal-wrapper');
        if(typeof(amw)!='undefined' && amw!=null){
          amw.style.display = 'block';

          var vbs = document.getElementById('auth-modal-vbs');
          if(vbs.innerHTML==''){

            var mp = document.getElementById('auth-modal-preloader');
            mp.style.display = 'block';

            $.ajax('get', 'req=auth_modal_content', function(data){
              vbs.innerHTML = data;
              mp.style.display = 'none';

              z.initEvents();

            });

          }

        }*/
      };

      //send auth modal form
      this.authFormAction = function(t){
        if(t.tagName.toLowerCase() != 'form'){
          var a_b = t.parentNode.parentNode.parentNode;
        } else {
          var a_b = t.parentNode;
        }
          var a = a_b.getAttribute('id').split('-')[1];
                  console.log(a);

        var err = 0;

        if(a == 'signin'){

          var e_email = document.getElementById('login_email'),
              e_password = document.getElementById('login_password');

          var email = e_email.value,
              password = e_password.value;

          if(email=='' || !$.validateEmail(email)){
            ++err;
            var err_fn = e_email.parentNode.getElementsByClassName('err');
            if(err_fn.length==0){
              $.addError(e_email, 'email');
            }
          }
          if(password=='' || password.length<6){
            ++err;
            var err_fn = e_password.parentNode.getElementsByClassName('err');
            if(err_fn.length==0){
              $.addError(e_password, 'password');
            }
          }

        } else if(a == 'join'){

          var e_fn = document.getElementById('join_fn'),
              e_ln = document.getElementById('join_ln'),
              e_email = document.getElementById('join_email'),
              e_password = document.getElementById('join_password'),
              is_newsletter = document.getElementById('join_newsletter').className.split('checked').length==2 ? 1 : 0;

          var fn = e_fn.value,
              ln = e_ln.value,
              email = e_email.value,
              password = e_password.value;

          if(fn==''){
            ++err;
            var err_fn = e_fn.parentNode.getElementsByClassName('err');
            if(err_fn.length==0){
              $.addError(e_fn, 'first_name');
            }
          }
          if(ln==''){
            ++err;
            var err_fn = e_ln.parentNode.getElementsByClassName('err');
            if(err_fn.length==0){
              $.addError(e_ln, 'last_name');
            }
          }
          if(email=='' || !$.validateEmail(email)){
            ++err;
            var err_fn = e_email.parentNode.getElementsByClassName('err');
            if(err_fn.length==0){
              $.addError(e_email, 'email');
            }
          }
          if(password=='' || password.length<6){
            ++err;
            var err_fn = e_password.parentNode.getElementsByClassName('err');
            if(err_fn.length==0){
              $.addError(e_password, 'password');
            }
          }

        } else {
          var e_email = document.getElementById('restore_email');
          var email = e_email.value;
          if(email=='' || !$.validateEmail(email)){
            ++err;
            var err_fn = e_email.parentNode.getElementsByClassName('err');
            if(err_fn.length==0){
              $.addError(e_email, 'email');
            }
          }
        }

        if(err){
          return false;
        }

        var mp = document.getElementById('auth-modal-preloader');
        mp.style.display = 'block';

        if(a == 'signin'){
          var login_errors = a_b.getElementsByClassName('err');
          for(var i=0;i<login_errors.length;++i){
            $.remove(login_errors[i]);
          }
          $.ajax('get', 'req=signin&email='+JSON.stringify(email)+'&password='+password, function(data){
            mp.style.display = 'none';
            var data = JSON.parse(data);
            if(data.status == true){
              window.location.reload();
            } else {
              if(data.result == 'wrong_password'){
                $.addError(e_password, data.result);
              } else if(data.result == 'user_not_found'){
                $.addError(e_email, data.result);
              }
            }
          });
        } else if(a == 'join'){
          $.ajax('get', 'req=join&email='+JSON.stringify(email)+'&first_name='+JSON.stringify(fn)+'&last_name='+JSON.stringify(ln)+'&is_newsletter='+is_newsletter+'&password='+password, function(data){
            mp.style.display = 'none';
            var data = JSON.parse(data);
            if(data.status == true){
            var join_form = document.getElementById('vb-join-form');
            //join_form.innerHTML = '<div class="sub-modal-header">Введите код, отправленный в SMS сообщении.</div><div class="inline-input input-sms-code"><span class="label">SMS Код</span><input id="join_code" type="text" /></div><div><a class="btn doact">Завершить</a></div><input class="super_hidden" type="submit" name="submit" value="submit" />';
            join_form.innerHTML = '<h3 class="modal-content-header">Спасибо, что выбрали наш магазин! ;-)</h3><img src="/st/images/off/phonecat.png">';
            setTimeout(function(){
              window.location.reload();
            }, 1300);
            } else {
              if(data.result == 'email_is_registered'){
                $.addError(e_email, 'email_is_registered');
              }
            }
          });
        } else if(a == 'restore'){
          mp.style.display = 'none';
          var restore_form = document.getElementById('vb-restore-form');
          restore_form.innerHTML = '<h3 class="modal-content-header">Ну, вот, а вы переживали :)</h3><img src="/st/images/off/phonecat.png"><div class="sub-modal-header">Нет причин беспокоиться :-)</div><div class="inline-input input-sms-code"><span class="label">SMS Код</span><input id="join_code" type="text" /></div><div><a class="btn doact">Завершить</a></div><input class="super_hidden" type="submit" name="submit" value="submit" />';
          setTimeout(function(){
            var restore_code = document.getElementById('restore_code');
            restore_code.focus();
          }, 500);
        }
        

        return false;

      }
      //switch tabs in auth modal
      this.changeAuthModalTab = function(t){
        var a = t.getAttribute('attr');
        var am = document.getElementById('auth-modal');
        if(a=='join' || a=='restore'){
          am.className = 'joinfix';
        } else {
          am.className = '';
        }

        var amt = document.getElementById('auth-modal-inner').getElementsByClassName('modal-nav')[0].getElementsByTagName('div');
        for(var i=0;i<amt.length;++i){
          if(amt[i].className == 'selected'){
            amt[i].className = '';
          }
          if(amt[i].getAttribute('attr') == a){
            amt[i].className = 'selected';
          }
        }


        var vbs = document.getElementById('auth-modal-vbs');
        var vbs_list = vbs.getElementsByClassName('vb');
        for(var i=0;i<vbs_list.length;++i){
          if(vbs_list[i].id == 'vb-'+a){
            vbs_list[i].className = vbs_list[i].className.replace('hidden', '').trim();
          } else {
            vbs_list[i].className = vbs_list[i].className.appendStyle('hidden');
          }
        }

      }

    }
  };

//})();

//tiny slider
var tns=function(){Object.keys||(Object.keys=function(t){var e=[];for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&e.push(n);return e}),function(){"use strict";"remove"in Element.prototype||(Element.prototype.remove=function(){this.parentNode&&this.parentNode.removeChild(this)})}();var t=window,hi=t.requestAnimationFrame||t.webkitRequestAnimationFrame||t.mozRequestAnimationFrame||t.msRequestAnimationFrame||function(t){return setTimeout(t,16)},e=window,pi=e.cancelAnimationFrame||e.mozCancelAnimationFrame||function(t){clearTimeout(t)};function mi(){for(var t,e,n,i=arguments[0]||{},a=1,r=arguments.length;a<r;a++)if(null!==(t=arguments[a]))for(e in t)i!==(n=t[e])&&void 0!==n&&(i[e]=n);return i}function gi(t){return 0<=["true","false"].indexOf(t)?JSON.parse(t):t}function yi(t,e,n){return n&&localStorage.setItem(t,e),e}function xi(){var t=document,e=t.body;return e||((e=t.createElement("body")).fake=!0),e}var n=document.documentElement;function bi(t){var e="";return t.fake&&(e=n.style.overflow,t.style.background="",t.style.overflow=n.style.overflow="hidden",n.appendChild(t)),e}function wi(t,e){t.fake&&(t.remove(),n.style.overflow=e,n.offsetHeight)}function Ci(t,e,n,i){"insertRule"in t?t.insertRule(e+"{"+n+"}",i):t.addRule(e,n,i)}function Ai(t){return("insertRule"in t?t.cssRules:t.rules).length}function Ti(t,e,n){for(var i=0,a=t.length;i<a;i++)e.call(n,t[i],i)}var i="classList"in document.createElement("_"),Ei=i?function(t,e){return t.classList.contains(e)}:function(t,e){return 0<=t.className.indexOf(e)},Mi=i?function(t,e){Ei(t,e)||t.classList.add(e)}:function(t,e){Ei(t,e)||(t.className+=" "+e)},ki=i?function(t,e){Ei(t,e)&&t.classList.remove(e)}:function(t,e){Ei(t,e)&&(t.className=t.className.replace(e,""))};function Ni(t,e){return t.hasAttribute(e)}function r(t){return void 0!==t.item}function Oi(t,e){if(t=r(t)||t instanceof Array?t:[t],"[object Object]"===Object.prototype.toString.call(e))for(var n=t.length;n--;)for(var i in e)t[n].setAttribute(i,e[i])}function Di(t,e){t=r(t)||t instanceof Array?t:[t];for(var n=(e=e instanceof Array?e:[e]).length,i=t.length;i--;)for(var a=n;a--;)t[i].removeAttribute(e[a])}function Bi(t){t.style.cssText=""}function Li(t){Ni(t,"hidden")||Oi(t,{hidden:""})}function Si(t){Ni(t,"hidden")&&Di(t,"hidden")}function Ii(t){return 0<t.offsetWidth&&0<t.offsetHeight}function Pi(e){if("string"==typeof e){var n=[e],i=e.charAt(0).toUpperCase()+e.substr(1);["Webkit","Moz","ms","O"].forEach(function(t){"ms"===t&&"transform"!==e||n.push(t+i)}),e=n}for(var t=document.createElement("fakeelement"),a=(e.length,0);a<e.length;a++){var r=e[a];if(void 0!==t.style[r])return r}return!1}function Wi(t,e){var n=!1;return/^Webkit/.test(t)?n="webkit"+e+"End":/^O/.test(t)?n="o"+e+"End":t&&(n=e.toLowerCase()+"end"),n}var a=!1;try{var o=Object.defineProperty({},"passive",{get:function(){a=!0}});window.addEventListener("test",null,o)}catch(t){}var s=!!a&&{passive:!0};function Ri(t,e){for(var n in e){var i=("touchstart"===n||"touchmove"===n)&&s;t.addEventListener(n,e[n],i)}}function Hi(t,e){for(var n in e){var i=0<=["touchstart","touchmove"].indexOf(n)&&s;t.removeEventListener(n,e[n],i)}}function zi(){return{topics:{},on:function(t,e){this.topics[t]=this.topics[t]||[],this.topics[t].push(e)},off:function(t,e){if(this.topics[t])for(var n=0;n<this.topics[t].length;n++)if(this.topics[t][n]===e){this.topics[t].splice(n,1);break}},emit:function(t,e){this.topics[t]&&this.topics[t].forEach(function(t){t(e)})}}}var qi=function(C){C=mi({container:".slider",mode:"carousel",axis:"horizontal",items:1,gutter:0,edgePadding:0,fixedWidth:!1,fixedWidthViewportWidth:!1,slideBy:1,controls:!0,controlsText:["prev","next"],controlsContainer:!1,prevButton:!1,nextButton:!1,nav:!0,navContainer:!1,navAsThumbnails:!1,arrowKeys:!1,speed:300,autoplay:!1,autoplayTimeout:5e3,autoplayDirection:"forward",autoplayText:["start","stop"],autoplayHoverPause:!1,autoplayButton:!1,autoplayButtonOutput:!0,autoplayResetOnVisibility:!0,loop:!0,rewind:!1,autoHeight:!1,responsive:!1,lazyload:!1,touch:!0,mouseDrag:!1,swipeAngle:15,nested:!1,freezable:!0,onInit:!1,useLocalStorage:!0},C||{});var k=document,A=window,s=13,u=32,l=33,c=34,f=35,d=36,v=37,h=38,p=39,m=40,e={},n=C.useLocalStorage;if(n){var t=navigator.userAgent;try{(e=localStorage).tnsApp!==t&&["tC","tPL","tMQ","tTf","t3D","tTDu","tTDe","tADu","tADe","tTE","tAE"].forEach(function(t){e.removeItem(t)}),localStorage.tnsApp=t}catch(t){n=!1}n&&!localStorage&&(n=!(e={}))}for(var i,a,r,o,g,y,x,T=e.tC?gi(e.tC):yi("tC",function(){var t=document,e=xi(),n=bi(e),i=t.createElement("div"),a=!1;e.appendChild(i);try{for(var r,o="(10px * 10)",s=["calc"+o,"-moz-calc"+o,"-webkit-calc"+o],u=0;u<3;u++)if(r=s[u],i.style.width=r,100===i.offsetWidth){a=r.replace(o,"");break}}catch(t){}return e.fake?wi(e,n):i.remove(),a}(),n),E=e.tPL?gi(e.tPL):yi("tPL",function(){var t,e=document,n=xi(),i=bi(n),a=e.createElement("div"),r=e.createElement("div"),o="";a.className="tns-t-subp2",r.className="tns-t-ct";for(var s=0;s<70;s++)o+="<div></div>";return r.innerHTML=o,a.appendChild(r),n.appendChild(a),t=Math.abs(a.getBoundingClientRect().left-r.children[67].getBoundingClientRect().left)<2,n.fake?wi(n,i):a.remove(),t}(),n),N=e.tMQ?gi(e.tMQ):yi("tMQ",(a=document,r=xi(),o=bi(r),g=a.createElement("div"),y=a.createElement("style"),x="@media all and (min-width:1px){.tns-mq-test{position:absolute}}",y.type="text/css",g.className="tns-mq-test",r.appendChild(y),r.appendChild(g),y.styleSheet?y.styleSheet.cssText=x:y.appendChild(a.createTextNode(x)),i=window.getComputedStyle?window.getComputedStyle(g).position:g.currentStyle.position,r.fake?wi(r,o):g.remove(),"absolute"===i),n),b=e.tTf?gi(e.tTf):yi("tTf",Pi("transform"),n),w=e.t3D?gi(e.t3D):yi("t3D",function(t){if(!t)return!1;if(!window.getComputedStyle)return!1;var e,n=document,i=xi(),a=bi(i),r=n.createElement("p"),o=9<t.length?"-"+t.slice(0,-9).toLowerCase()+"-":"";return o+="transform",i.insertBefore(r,null),r.style[t]="translate3d(1px,1px,1px)",e=window.getComputedStyle(r).getPropertyValue(o),i.fake?wi(i,a):r.remove(),void 0!==e&&0<e.length&&"none"!==e}(b),n),M=e.tTDu?gi(e.tTDu):yi("tTDu",Pi("transitionDuration"),n),O=e.tTDe?gi(e.tTDe):yi("tTDe",Pi("transitionDelay"),n),D=e.tADu?gi(e.tADu):yi("tADu",Pi("animationDuration"),n),B=e.tADe?gi(e.tADe):yi("tADe",Pi("animationDelay"),n),L=e.tTE?gi(e.tTE):yi("tTE",Wi(M,"Transition"),n),S=e.tAE?gi(e.tAE):yi("tAE",Wi(D,"Animation"),n),I=A.console&&"function"==typeof A.console.warn,P=["container","controlsContainer","prevButton","nextButton","navContainer","autoplayButton"],W=P.length;W--;){var R=P[W];if("string"==typeof C[R]){var H=k.querySelector(C[R]);if(!H||!H.nodeName)return void(I&&console.warn("Can't find",C[R]));C[R]=H}}if(!(C.container.children.length<1)){if(C.responsive){var z={},q=C.responsive;for(var j in q){var F=q[j];z[j]="number"==typeof F?{items:F}:F}C.responsive=z,z=null,0 in C.responsive&&delete(C=mi(C,C.responsive[0])).responsive[0]}var V="carousel"===C.mode;if(!V){C.axis="horizontal",C.edgePadding=!1;var Q="tns-fadeIn",X="tns-fadeOut",Y=!1,K=C.animateNormal||"tns-normal";L&&S&&(Q=C.animateIn||Q,X=C.animateOut||X,Y=C.animateDelay||Y)}var U,G,J="horizontal"===C.axis,_=k.createElement("div"),Z=k.createElement("div"),$=C.container,tt=$.parentNode,et=$.children,nt=et.length,it=C.responsive,at=[],rt=!1,ot=0,st=un();if(C.fixedWidth)var ut=ln(tt);if(it){(rt=Object.keys(it).map(function(t){return parseInt(t)}).sort(function(t,e){return t-e})).forEach(function(t){at=at.concat(Object.keys(it[t]))});var lt=[];at.forEach(function(t){lt.indexOf(t)<0&&lt.push(t)}),at=lt,wn()}var ct,ft,dt,vt,ht,pt,mt,gt,yt=fn("items"),xt="page"===fn("slideBy")?yt:fn("slideBy"),bt=C.nested,wt=fn("gutter"),Ct=fn("edgePadding"),At=fn("fixedWidth"),Tt=C.fixedWidthViewportWidth,Et=fn("arrowKeys"),Mt=fn("speed"),kt=C.rewind,Nt=!kt&&C.loop,Ot=fn("autoHeight"),Dt=(gt=document.createElement("style"),mt&&gt.setAttribute("media",mt),document.querySelector("head").appendChild(gt),gt.sheet?gt.sheet:gt.styleSheet),Bt=C.lazyload,Lt=[],St=cn("edgePadding"),It=Nt?(ht=function(){{if(At&&!Tt)return nt-1;var n=At?"fixedWidth":"items",i=[];return(At||C[n]<nt)&&i.push(C[n]),rt&&0<=at.indexOf(n)&&rt.forEach(function(t){var e=it[t][n];e&&(At||e<nt)&&i.push(e)}),i.length||i.push(0),At?Math.ceil(Tt/Math.min.apply(null,i)):Math.max.apply(null,i)}}(),pt=V?Math.ceil((5*ht-nt)/2):4*ht-nt,pt=Math.max(ht,pt),St?pt+1:pt):0,Pt=V?nt+2*It:nt+It,Wt=!(!At||Nt||Ct),Rt=!V||!Nt,Ht=J?"left":"top",zt="",qt="",jt=fn("startIndex"),Ft=jt?function(t){(t%=nt)<0&&(t+=nt);return t=Math.min(t,Pt-yt)}(jt):V?It:0,Vt=Ft,Qt=0,Xt=on(),Yt=C.swipeAngle,Kt=!Yt||"?",Ut=!1,Gt=C.onInit,Jt=new zi,_t=$.id,Zt=" tns-slider tns-"+C.mode,$t=$.id||(vt=window.tnsId,window.tnsId=vt?vt+1:1,"tns"+window.tnsId),te=fn("disable"),ee=C.freezable,ne=!!te||!!ee&&nt<=yt,ie="inner"===bt?" !important":"",ae={click:Gn,keydown:function(t){switch((t=ai(t)).keyCode){case v:case h:case l:Ee.disabled||Gn(t,-1);break;case p:case m:case c:Me.disabled||Gn(t,1);break;case d:Un("first",t);break;case f:Un(nt-1,t)}}},re={click:function(t){Ut&&Kn();var e,n=(t=ai(t)).target||t.srcElement;for(;n!==Oe&&!Ni(n,"data-nav");)n=n.parentNode;Ni(n,"data-nav")&&(e=Le=[].indexOf.call(ke,n),Un(V?e+It:e,t))},keydown:function(t){var e=k.activeElement;if(!Ni(e,"data-nav"))return;var n=(t=ai(t)).keyCode,i=[].indexOf.call(ke,e),a=De.length,r=De.indexOf(i);C.navContainer&&(a=nt,r=i);function o(t){return C.navContainer?t:De[t]}switch(n){case v:case l:0<r&&ni(ke[o(r-1)]);break;case h:case d:0<r&&ni(ke[o(0)]);break;case p:case c:r<a-1&&ni(ke[o(r+1)]);break;case m:case f:r<a-1&&ni(ke[o(a-1)]);break;case s:case u:Un((Le=i)+It,t)}}},oe={mouseover:function(){Re&&(_n(),He=!0)},mouseout:function(){He&&(Jn(),He=!1)}},se={visibilitychange:function(){k.hidden?Re&&(_n(),qe=!0):qe&&(Jn(),qe=!1)}},ue={keydown:function(t){switch((t=ai(t)).keyCode){case v:Gn(t,-1);break;case p:Gn(t,1)}}},le={touchstart:ui,touchmove:li,touchend:ci,touchcancel:ci},ce={mousedown:ui,mousemove:li,mouseup:ci,mouseleave:ci},fe=cn("controls"),de=cn("nav"),ve=C.navAsThumbnails,he=cn("autoplay"),pe=cn("touch"),me=cn("mouseDrag"),ge="tns-slide-active",ye="tns-complete",xe={load:Mn,error:Mn};if(fe)var be,we,Ce=fn("controls"),Ae=fn("controlsText"),Te=C.controlsContainer,Ee=C.prevButton,Me=C.nextButton;if(de)var ke,Ne=fn("nav"),Oe=C.navContainer,De=[],Be=De,Le=-1,Se=sn(),Ie=Se,Pe="tns-nav-active";if(he)var We,Re,He,ze,qe,je=fn("autoplay"),Fe=fn("autoplayTimeout"),Ve="forward"===C.autoplayDirection?1:-1,Qe=fn("autoplayText"),Xe=fn("autoplayHoverPause"),Ye=C.autoplayButton,Ke=fn("autoplayResetOnVisibility"),Ue=["<span class='tns-visually-hidden'>"," animation</span>"];if(pe||me)var Ge,Je={},_e={},Ze=!1,$e=0,tn=J?function(t,e){return t.x-e.x}:function(t,e){return t.y-e.y};if(pe)var en=fn("touch");if(me)var nn=fn("mouseDrag");ne&&(Ce=Ne=en=nn=Et=je=Xe=Ke=!1),b&&(Ht=b,zt="translate",w?(zt+=J?"3d(":"3d(0px, ",qt=J?", 0px, 0px)":", 0px)"):(zt+=J?"X(":"Y(",qt=")")),function(){_.appendChild(Z),tt.insertBefore(_,$),Z.appendChild($);var t="tns-outer",e="tns-inner",n=cn("gutter");V?J&&(cn("edgePadding")||n&&!C.fixedWidth)?t+=" tns-ovh":e+=" tns-ovh":n&&(t+=" tns-ovh"),_.className=t,Z.className=e,Z.id=$t+"-iw",Ot&&(Z.className+=" tns-ah"),""===$.id&&($.id=$t),Zt+=E?" tns-subpixel":" tns-no-subpixel",Zt+=T?" tns-calc":" tns-no-calc",V&&(Zt+=" tns-"+C.axis),$.className+=Zt,U=ln(Z);var i=fn("edgePadding");fn("gutter");if(U+=i?-(2*i+wt):wt,V&&L){var a={};a[L]=Kn,Ri($,a)}t=e=null;for(var r=0;r<nt;r++){(g=et[r]).id||(g.id=$t+"-item"+r),Mi(g,"tns-item"),!V&&K&&Mi(g,K),Oi(g,{"aria-hidden":"true",tabindex:"-1"})}if(Nt||Ct){for(var o=k.createDocumentFragment(),s=k.createDocumentFragment(),u=It;u--;){var l=u%nt,c=et[l].cloneNode(!0);if(Di(c,"id"),s.insertBefore(c,s.firstChild),V){var f=et[nt-1-l].cloneNode(!0);Di(f,"id"),o.appendChild(f)}}$.insertBefore(o,$.firstChild),$.appendChild(s),et=$.children}if(cn("autoHeight")||!V||!J){var d=$.querySelectorAll("img");Ti(d,function(t){Ri(t,xe);var e=t.src;t.src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",t.src=e}),hi(function(){On(function(t){for(var e=[],n=0,i=t.length;n<i;n++)e.push(t[n]);return e}(d),function(){dt=!0,te||(J||(Sn(),fi()),V&&Fn())})})}V&&J&&Fn();for(var v=Ft,h=Ft+Math.min(nt,yt);v<h;v++){Oi(g=et[v],{"aria-hidden":"false"}),Di(g,["tabindex"]),Mi(g,ge),V||(g.style.left=100*(v-Ft)/yt+"%",Mi(g,Q),ki(g,K))}if(V&&J&&(E?(Ci(Dt,"#"+$t+" > .tns-item","font-size:"+A.getComputedStyle(et[0]).fontSize+";",Ai(Dt)),Ci(Dt,"#"+$t,"font-size:0;",Ai(Dt))):Ti(et,function(t,e){t.style.marginLeft=U*e/yt+"px"})),N){var p=dn(C.edgePadding,C.gutter,C.fixedWidth,C.speed);Ci(Dt,"#"+$t+"-iw",p,Ai(Dt)),V&&(p=J?"width:"+vn(C.fixedWidth,C.gutter,C.items)+";":"",M&&(p+=gn(Mt)),Ci(Dt,"#"+$t,p,Ai(Dt))),p=J?hn(C.fixedWidth,C.gutter,C.items):"",C.gutter&&(p+=pn(C.gutter)),V||(M&&(p+=gn(Mt)),D&&(p+=yn(Mt))),p&&Ci(Dt,"#"+$t+" > .tns-item",p,Ai(Dt))}else{Z.style.cssText=dn(Ct,wt,At),V&&J&&($.style.width=vn(At,wt,yt));p=J?hn(At,wt,yt):"";wt&&(p+=pn(wt)),p&&Ci(Dt,"#"+$t+" > .tns-item",p,Ai(Dt))}if(it&&N&&rt.forEach(function(t){var e,n=it[t],i="",a="",r="",o=fn("items",t),s=fn("fixedWidth",t),u=fn("speed",t),l=fn("edgePadding",t),c=fn("gutter",t);("edgePadding"in n||"gutter"in n)&&(i="#"+$t+"-iw{"+dn(l,c,s,u)+"}"),V&&J&&("fixedWidth"in n||"items"in n||At&&"gutter"in n)&&(a="width:"+vn(s,c,o)+";"),M&&"speed"in n&&(a+=gn(u)),a&&(a="#"+$t+"{"+a+"}"),("fixedWidth"in n||At&&"gutter"in n||!V&&"items"in n)&&(r+=hn(s,c,o)),"gutter"in n&&(r+=pn(c)),!V&&"speed"in n&&(M&&(r+=gn(u)),D&&(r+=yn(u))),r&&(r="#"+$t+" > .tns-item{"+r+"}"),(e=i+a+r)&&Dt.insertRule("@media (min-width: "+t/16+"em) {"+e+"}",Dt.cssRules.length)}),navigator.msMaxTouchPoints&&(Mi($,"ms-touch"),Ri($,{scroll:ii}),In()),de){var m=V?It:0;if(Oe){Oi(Oe,{"aria-label":"Carousel Pagination"}),ke=Oe.children;for(v=0;v<nt;v++){var g;(g=ke[v])&&Oi(g,{"data-nav":v,tabindex:"-1","aria-selected":"false","aria-controls":et[m+v].id})}}else{var y="",x=ve?"":"hidden";for(v=0;v<nt;v++)y+='<button data-nav="'+v+'" tabindex="-1" aria-selected="false" aria-controls="'+et[m+v].id+'" '+x+' type="button"></button>';y='<div class="tns-nav" aria-label="Carousel Pagination">'+y+"</div>",_.insertAdjacentHTML("afterbegin",y),Oe=_.querySelector(".tns-nav"),ke=Oe.children}if(di(),M){var b=M.substring(0,M.length-18).toLowerCase();p="transition: all "+Mt/1e3+"s";b&&(p="-"+b+"-"+p),Ci(Dt,"[aria-controls^="+$t+"-item]",p,Ai(Dt))}Oi(ke[Se],{tabindex:"0","aria-selected":"true"}),Mi(ke[Se],Pe),Ri(Oe,re),Ne||Li(Oe)}if(he){var w=je?"stop":"start";Ye?Oi(Ye,{"data-action":w}):C.autoplayButtonOutput&&(Z.insertAdjacentHTML("beforebegin",'<button data-action="'+w+'" type="button">'+Ue[0]+w+Ue[1]+Qe[0]+"</button>"),Ye=_.querySelector("[data-action]")),Ye&&Ri(Ye,{click:ei}),je?($n(),Xe&&Ri($,oe),Ke&&Ri($,se)):Ye&&Li(Ye)}fe&&(Te||Ee&&Me?(Te&&(Ee=Te.children[0],Me=Te.children[1],Oi(Te,{"aria-label":"Carousel Navigation",tabindex:"0"}),Oi(Te.children,{"aria-controls":$t,tabindex:"-1"})),Oi(Ee,{"data-controls":"prev"}),Oi(Me,{"data-controls":"next"})):(_.insertAdjacentHTML("afterbegin",'<div class="tns-controls" aria-label="Carousel Navigation" tabindex="0"><div class="slidetns icon-arrow-left" data-controls="prev" tabindex="-1" aria-controls="'+$t+'"></div><div class="slidetns icon-arrow-right" data-controls="next" tabindex="-1" aria-controls="'+$t+'"></div></div>'),Te=_.querySelector(".tns-controls"),Ee=Te.children[0],Me=Te.children[1]),be=Wn(Ee),we=Wn(Me),zn(),Te?Ri(Te,ae):(Ri(Ee,ae),Ri(Me,ae)),Ce||Li(Te)),V&&(en&&Ri($,le),nn&&Ri($,ce)),Et&&Ri(k,ue),"inner"===bt?Jt.on("outerResized",function(){bn(),Jt.emit("innerLoaded",vi())}):Ri(A,{resize:xn}),"outer"===bt?Jt.on("innerLoaded",Nn):!Ot&&V||te||Nn(),En(),Cn(),An(),Jt.on("indexChanged",Dn),"function"==typeof Gt&&Gt(vi()),"inner"===bt&&Jt.emit("innerLoaded",vi()),te&&Tn(!0),G=!0}();var an=Nt?V?function(){var t=Qt,e=Xt;if(t+=xt,e-=xt,Ct)t+=1,e-=1;else if(At){var n=wt||0;n<ut%(At+n)&&(e-=1)}It&&(e<Ft?Ft-=nt:Ft<t&&(Ft+=nt))}:function(){if(Xt<Ft)for(;Qt+nt<=Ft;)Ft-=nt;else if(Ft<Qt)for(;Ft<=Xt-nt;)Ft+=nt}:function(){Ft=Math.max(Qt,Math.min(Xt,Ft))},rn=V?function(t,e){var n,i,a,r,o,s,u,l,c,f,d;e||(e=jn()),Wt&&Ft===Xt&&(e=-((At+wt)*Pt-U)+"px"),M||!t?(Vn(e),t&&Ii($)||Kn()):(n=$,i=Ht,a=zt,r=qt,o=e,s=Mt,u=Kn,l=Math.min(s,10),c=0<=o.indexOf("%")?"%":"px",o=o.replace(c,""),f=Number(n.style[i].replace(a,"").replace(r,"").replace(c,"")),d=(o-f)/s*l,setTimeout(function t(){s-=l,f+=d,n.style[i]=a+f+c+r,0<s?setTimeout(t,l):u()},l)),J||fi()}:function(t){Lt=[];var e={};e[L]=e[S]=Kn,Hi(et[Vt],e),Ri(et[Ft],e),Qn(Vt,Q,X,!0),Qn(Ft,K,Q),L&&S&&t||Kn()};return{getInfo:vi,events:Jt,goTo:Un,play:function(){je&&!Re&&($n(),ze=!1)},pause:function(){Re&&(ti(),ze=!0)},isOn:G,updateSliderHeight:Ln,rebuild:function(){return qi(C)},destroy:function(){if(Hi(A,{resize:xn}),Hi(k,ue),Dt.disabled=!0,Nt)for(var t=It;t--;)V&&et[0].remove(),et[et.length-1].remove();var e=["tns-item",ge];V||(e=e.concat("tns-normal",Q));for(var n=nt;n--;){var i=et[n];0<=i.id.indexOf($t+"-item")&&(i.id=""),e.forEach(function(t){ki(i,t)})}if(Di(et,["style","aria-hidden","tabindex"]),et=$t=nt=Pt=It=null,Ce&&(Hi(Te,ae),C.controlsContainer&&(Di(Te,["aria-label","tabindex"]),Di(Te.children,["aria-controls","aria-disabled","tabindex"])),Te=Ee=Me=null),Ne&&(Hi(Oe,re),C.navContainer&&(Di(Oe,["aria-label"]),Di(ke,["aria-selected","aria-controls","tabindex"])),Oe=ke=null),je&&(clearInterval(We),Ye&&Hi(Ye,{click:ei}),Hi($,oe),Hi($,se),C.autoplayButton&&Di(Ye,["data-action"])),$.id=_t||"",$.className=$.className.replace(Zt,""),Bi($),V&&L){var a={};a[L]=Kn,Hi($,a)}Hi($,le),Hi($,ce),tt.insertBefore($,_),_.remove(),_=Z=$=Ft=Vt=yt=xt=Se=Ie=fe=De=Be=this.getInfo=this.events=this.goTo=this.play=this.pause=this.destroy=null,this.isOn=G=!1}}}function on(){return V||Nt?Math.max(0,Pt-yt):Pt-1}function sn(t){void 0===t&&(t=Ft);for(var e=V?It:0;t<e;)t+=nt;return V&&(t-=It),t?t%nt:t}function un(){return A.innerWidth||k.documentElement.clientWidth||k.body.clientWidth}function ln(t){return t.clientWidth||ln(t.parentNode)}function cn(e){var n=C[e];return!n&&rt&&0<=at.indexOf(e)&&rt.forEach(function(t){it[t][e]&&(n=!0)}),n}function fn(t,e){e=e||st;var n,i={slideBy:"page",edgePadding:!1};if(!V&&t in i)n=i[t];else if("items"===t&&fn("fixedWidth"))n=Math.floor(ut/(fn("fixedWidth")+fn("gutter")));else if("autoHeight"===t&&"outer"===bt)n=!0;else if(n=C[t],rt&&0<=at.indexOf(t))for(var a=0,r=rt.length;a<r;a++){var o=rt[a];if(!(o<=e))break;t in it[o]&&(n=it[o][t])}return"slideBy"===t&&"page"===n&&(n=fn("items")),n}function dn(t,e,n,i){var a="";if(t){var r=t;e&&(r+=e),a=n?"margin: 0px "+(ut%(n+e)+e)/2+"px;":J?"margin: 0 "+t+"px 0 "+r+"px;":"padding: "+r+"px 0 "+t+"px 0;"}else if(e&&!n){var o="-"+e+"px";a="margin: 0 "+(J?o+" 0 0":"0 "+o+" 0")+";"}return M&&i&&(a+=gn(i)),a}function vn(t,e,n){return t?(t+e)*Pt+"px":T?T+"("+100*Pt+"% / "+n+")":100*Pt/n+"%"}function hn(t,e,n){var i;if(t)i=t+e+"px";else{var a=V?Pt:n;i=T?T+"(100% / "+a+")":100/a+"%"}return"width:"+i+ie+";"}function pn(t){var e="";!1!==t&&(e=(J?"padding-":"margin-")+(J?"right":"bottom")+": "+t+"px;");return e}function mn(t,e){var n=t.substring(0,t.length-e).toLowerCase();return n&&(n="-"+n+"-"),n}function gn(t){return mn(M,18)+"transition-duration:"+t/1e3+"s;"}function yn(t){return mn(D,17)+"animation-duration:"+t/1e3+"s;"}function xn(t){hi(function(){bn(ai(t))})}function bn(t){if(G){st=un(),"outer"===bt&&Jt.emit("outerResized",vi(t));var e,n,i=ot,a=Ft,r=yt,o=ne,s=!1;if(At&&(ut=ln(_)),U=ln(Z),rt&&wn(),i!==ot&&Jt.emit("newBreakpointStart",vi(t)),i!==ot||At){var u=Et,l=Ot,c=At,f=Ct,d=wt,v=te;if(yt=fn("items"),xt=fn("slideBy"),te=fn("disable"),ne=!!te||!!ee&&nt<=yt,yt!==r&&(Xt=on(),an()),te!==v&&Tn(te),ne!==o&&(ne&&(Ft=V?It:0),Cn()),i!==ot&&(Mt=fn("speed"),Ct=fn("edgePadding"),wt=fn("gutter"),At=fn("fixedWidth"),te||At===c||(s=!0),(Ot=fn("autoHeight"))!==l&&(Ot||(Z.style.height=""))),(Et=!ne&&fn("arrowKeys"))!==u&&(Et?Ri(k,ue):Hi(k,ue)),fe){var h=Ce,p=Ae;Ce=!ne&&fn("controls"),Ae=fn("controlsText"),Ce!==h&&(Ce?Si(Te):Li(Te)),Ae!==p&&(Ee.innerHTML=Ae[0],Me.innerHTML=Ae[1])}if(de){var m=Ne;(Ne=!ne&&fn("nav"))!==m&&(Ne?(Si(Oe),di()):Li(Oe))}if(pe){var g=en;(en=!ne&&fn("touch"))!==g&&V&&(en?Ri($,le):Hi($,le))}if(me){var y=nn;(nn=!ne&&fn("mouseDrag"))!==y&&V&&(nn?Ri($,ce):Hi($,ce))}if(he){var x=je,b=Xe,w=Ke,C=Qe;if(ne?je=Xe=Ke=!1:(je=fn("autoplay"))?(Xe=fn("autoplayHoverPause"),Ke=fn("autoplayResetOnVisibility")):Xe=Ke=!1,Qe=fn("autoplayText"),Fe=fn("autoplayTimeout"),je!==x&&(je?(Ye&&Si(Ye),Re||ze||$n()):(Ye&&Li(Ye),Re&&ti())),Xe!==b&&(Xe?Ri($,oe):Hi($,oe)),Ke!==w&&(Ke?Ri(k,se):Hi(k,se)),Ye&&Qe!==C){var A=je?1:0,T=Ye.innerHTML,E=T.length-C[A].length;T.substring(E)===C[A]&&(Ye.innerHTML=T.substring(0,E)+Qe[A])}}if(!N){if(ne||Ct===f&&wt===d||(Z.style.cssText=dn(Ct,wt,At)),J&&!At){V&&($.style.width=vn(!1,null,yt));var M=hn(At,wt,yt)+pn(wt);n=Ai(e=Dt)-1,"deleteRule"in e?e.deleteRule(n):e.removeRule(n),Ci(Dt,"#"+$t+" > .tns-item",M,Ai(Dt))}At||(s=!0)}Ft!==a&&(Jt.emit("indexChanged",vi()),s=!0),yt!==r&&(Dn(),function(){if(!V){for(var t=Ft+Math.min(nt,yt),e=Pt;e--;){var n=et[e];Ft<=e&&e<t?(Mi(n,"tns-moving"),n.style.left=100*(e-Ft)/yt+"%",Mi(n,Q),ki(n,K)):n.style.left&&(n.style.left="",Mi(n,K),ki(n,Q)),ki(n,X)}setTimeout(function(){Ti(et,function(t){ki(t,"tns-moving")})},300)}}(),navigator.msMaxTouchPoints&&In())}J||te||(Sn(),fi(),s=!0),s&&(Fn(),Vt=Ft),An(!0),!Ot&&V||te||Nn(),i!==ot&&Jt.emit("newBreakpointEnd",vi(t))}}function wn(){ot=0,rt.forEach(function(t,e){t<=st&&(ot=e+1)})}function Cn(){var t="tns-transparent";if(ne){if(!ft){if(Ct&&(Z.style.margin="0px"),It)for(var e=It;e--;)V&&Mi(et[e],t),Mi(et[Pt-e-1],t);ft=!0}}else if(ft){if(Ct&&!At&&N&&(Z.style.margin=""),It)for(e=It;e--;)V&&ki(et[e],t),ki(et[Pt-e-1],t);ft=!1}}function An(t){At&&Ct&&(ne||ut<=At+wt?"0px"!==Z.style.margin&&(Z.style.margin="0px"):t&&(Z.style.cssText=dn(Ct,wt,At)))}function Tn(t){var e=et.length;if(t){if(Dt.disabled=!0,$.className=$.className.replace(Zt.substring(1),""),Bi($),Nt)for(var n=It;n--;)V&&Li(et[n]),Li(et[e-n-1]);if(J&&V||Bi(Z),!V)for(var i=Ft,a=Ft+nt;i<a;i++){Bi(r=et[i]),ki(r,Q),ki(r,K)}}else{if(Dt.disabled=!1,$.className+=Zt,J||Sn(),Fn(),Nt)for(n=It;n--;)V&&Si(et[n]),Si(et[e-n-1]);if(!V)for(i=Ft,a=Ft+nt;i<a;i++){var r=et[i],o=i<Ft+yt?Q:K;r.style.left=100*(i-Ft)/yt+"%",Mi(r,o)}}}function En(){if(Bt&&!te){var t=Ft,e=Ft+yt;for(Ct&&(t-=1,e+=1),t=Math.max(t,0),e=Math.min(e,Pt);t<e;t++)Ti(et[t].querySelectorAll(".tns-lazy-img"),function(t){var e,n={};n[L]=function(t){t.stopPropagation()},Ri(t,n),Ei(t,"loaded")||(t.src=(e="data-src",t.getAttribute(e)),Mi(t,"loaded"))})}}function Mn(t){var e=ri(t);Mi(e,ye),Hi(e,xe)}function kn(t,e){for(var n=[],i=t,a=Math.min(t+e,Pt);i<a;i++)Ti(et[i].querySelectorAll("img"),function(t){n.push(t)});return n}function Nn(){var t=Ot?kn(Ft,yt):kn(It,nt);hi(function(){On(t,Ln)})}function On(n,t){return dt?t():(n.forEach(function(t,e){Ei(t,ye)&&n.splice(e,1)}),n.length?void hi(function(){On(n,t)}):t())}function Dn(){En(),function(){for(var t=Ft+Math.min(nt,yt),e=Pt;e--;){var n=et[e];Ft<=e&&e<t?Ni(n,"tabindex")&&(Oi(n,{"aria-hidden":"false"}),Di(n,["tabindex"]),Mi(n,ge)):(Ni(n,"tabindex")||Oi(n,{"aria-hidden":"true",tabindex:"-1"}),Ei(n,ge)&&ki(n,ge))}}(),zn(),di(),function(){if(Ne&&(Se=-1!==Le?Le:sn(),Le=-1,Se!==Ie)){var t=ke[Ie],e=ke[Se];Oi(t,{tabindex:"-1","aria-selected":"false"}),Oi(e,{tabindex:"0","aria-selected":"true"}),ki(t,Pe),Mi(e,Pe)}}()}function Bn(t,e){for(var n=[],i=t,a=Math.min(t+e,Pt);i<a;i++)n.push(et[i].offsetHeight);return Math.max.apply(null,n)}function Ln(){var t=Ot?Bn(Ft,yt):Bn(It,nt);Z.style.height!==t&&(Z.style.height=t+"px")}function Sn(){ct=[0];for(var t,e=et[0].getBoundingClientRect().top,n=1;n<Pt;n++)t=et[n].getBoundingClientRect().top,ct.push(t-e)}function In(){_.style.msScrollSnapPointsX="snapInterval(0%, "+100/yt+"%)"}function Pn(t){return t.nodeName.toLowerCase()}function Wn(t){return"button"===Pn(t)}function Rn(t){return"true"===t.getAttribute("aria-disabled")}function Hn(t,e,n){t?e.disabled=n:e.setAttribute("aria-disabled",n.toString())}function zn(){if(Ce&&!kt&&!Nt){var t=be?Ee.disabled:Rn(Ee),e=we?Me.disabled:Rn(Me),n=Ft===Qt,i=!kt&&Ft===Xt;n&&!t&&Hn(be,Ee,!0),!n&&t&&Hn(be,Ee,!1),i&&!e&&Hn(we,Me,!0),!i&&e&&Hn(we,Me,!1)}}function qn(t,e){M&&(t.style[M]=e)}function jn(){var t;J?t=At?-(At+wt)*Ft+"px":100*-Ft/(b?Pt:yt)+"%":t=-ct[Ft]+"px";return t}function Fn(t){qn($,"0s"),Vn(t),setTimeout(function(){qn($,"")},0)}function Vn(t,e){t||(t=jn()),$.style[Ht]=zt+t+qt}function Qn(t,e,n,i){var a=t+yt;Nt||(a=Math.min(a,Pt));for(var r=t;r<a;r++){var o=et[r];i||(o.style.left=100*(r-Ft)/yt+"%"),Y&&O&&(o.style[O]=o.style[B]=Y*(r-t)/1e3+"s"),ki(o,e),Mi(o,n),i&&Lt.push(o)}}function Xn(t,e){var n,i;Rt&&an(),(Ft!==Vt||e)&&(Jt.emit("indexChanged",vi()),Jt.emit("transitionStart",vi()),Re&&t&&0<=["click","keydown"].indexOf(t.type)&&ti(),Ut=!0,isNaN(n)&&(n=Mt),Re&&!Ii($)&&(n=0),rn(n,i))}function Yn(t){return t.toLowerCase().replace(/-/g,"")}function Kn(t){if(V||Ut){if(Jt.emit("transitionEnd",vi(t)),!V&&0<Lt.length)for(var e=0;e<Lt.length;e++){var n=Lt[e];n.style.left="",B&&O&&(n.style[B]="",n.style[O]=""),ki(n,X),Mi(n,K)}if(!t||!V&&t.target.parentNode===$||t.target===$&&Yn(t.propertyName)===Yn(Ht)){if(!Rt){var i=Ft;an(),Ft!==i&&(Jt.emit("indexChanged",vi()),Fn())}Ot&&Nn(),"inner"===bt&&Jt.emit("innerLoaded",vi()),Ut=!1,Ie=Se,Vt=Ft}}}function Un(t,e){if(!ne)if("prev"===t)Gn(e,-1);else if("next"===t)Gn(e,1);else{Ut&&Kn();var n=sn(),i=0;if(n<0&&(n+=nt),"first"===t)i=-n;else if("last"===t)i=V?nt-yt-n:nt-1-n;else if("number"!=typeof t&&(t=parseInt(t)),!isNaN(t)){e||(t-=1,V&&It&&(t+=It));var a=sn(t);a<0&&(a+=nt),i=a-n}if(!V&&i&&Math.abs(i)<yt){var r=0<i?1:-1;i+=Qt<=Ft+i-nt?nt*r:2*nt*r*-1}Ft+=i,V&&Nt&&(Ft<Qt&&(Ft+=nt),Xt<Ft&&(Ft-=nt)),sn(Ft)!==sn(Vt)&&Xn(e)}}function Gn(t,e){var n;if(Ut&&Kn(),!e){for(var i=(t=ai(t)).target||t.srcElement;i!==Te&&[Ee,Me].indexOf(i)<0;)i=i.parentNode;var a=[Ee,Me].indexOf(i);0<=a&&(n=!0,e=0===a?-1:1)}if(kt){if(Ft===Qt&&-1===e)return void Un("last",t);if(Ft===Xt&&1===e)return void Un("first",t)}e&&(Ft+=xt*e,Xn(n||t&&"keydown"===t.type?t:null))}function Jn(){We=setInterval(function(){Gn(null,Ve)},Fe),Re=!0}function _n(){clearInterval(We),Re=!1}function Zn(t,e){Oi(Ye,{"data-action":t}),Ye.innerHTML=Ue[0]+t+Ue[1]+e}function $n(){Jn(),Ye&&Zn("stop",Qe[1])}function ti(){_n(),Ye&&Zn("start",Qe[0])}function ei(){Re?(ti(),ze=!0):($n(),ze=!1)}function ni(t){t.focus()}function ii(){rn(0,$.scrollLeft),Vt=Ft}function ai(t){return oi(t=t||A.event)?t.changedTouches[0]:t}function ri(t){return t.target||A.event.srcElement}function oi(t){return 0<=t.type.indexOf("touch")}function si(t){t.preventDefault?t.preventDefault():t.returnValue=!1}function ui(t){Ut&&Kn(),Ze=!0,pi($e),$e=0;var e=ai(t);Jt.emit(oi(t)?"touchStart":"dragStart",vi(t)),!oi(t)&&0<=["img","a"].indexOf(Pn(ri(t)))&&si(t),_e.x=Je.x=parseInt(e.clientX),_e.y=Je.y=parseInt(e.clientY),Ge=parseFloat($.style[Ht].replace(zt,"").replace(qt,"")),qn($,"0s")}function li(t){if(Ze){var e=ai(t);_e.x=parseInt(e.clientX),_e.y=parseInt(e.clientY)}$e||($e=hi(function(){!function t(e){if(!Kt)return void(Ze=!1);pi($e);Ze&&($e=hi(function(){t(e)}));"?"===Kt&&_e.x!==Je.x&&_e.y!==Je.y&&(o=_e.y-Je.y,s=_e.x-Je.x,n=Math.atan2(o,s)*(180/Math.PI),i=Yt,a=!1,r=Math.abs(90-Math.abs(n)),90-i<=r?a="horizontal":r<=i&&(a="vertical"),Kt=a===C.axis);var n,i,a,r;var o,s;if(Kt){try{e.type&&Jt.emit(oi(e)?"touchMove":"dragMove",vi(e))}catch(t){}var u=Ge,l=tn(_e,Je);if(!J||At)u+=l,u+="px";else{var c=b?l*yt*100/(U*Pt):100*l/U;u+=c,u+="%"}$.style[Ht]=zt+u+qt}}(t)}))}function ci(i){if(Yt&&(Kt="?"),Ze){pi($e),qn($,""),Ze=!1;var t=ai(i);_e.x=parseInt(t.clientX),_e.y=parseInt(t.clientY);var a=tn(_e,Je);if(5<=Math.abs(a)){if(!oi(i)){var n=ri(i);Ri(n,{click:function t(e){si(e),Hi(n,{click:t})}})}$e=hi(function(){if(J){var t=-a*yt/U;t=0<a?Math.floor(t):Math.ceil(t),Ft+=t}else{var e=-(Ge+a);if(e<=0)Ft=Qt;else if(e>=ct[ct.length-1])Ft=Xt;else for(var n=0;n++,Ft=a<0?n+1:n,n<Pt&&e>=ct[n+1];);}Xn(i,a),Jt.emit(oi(i)?"touchEnd":"dragEnd",vi(i))})}}}function fi(){Z.style.height=ct[Ft+yt]-ct[Ft]+"px"}function di(){Ne&&!ve&&(!function(){De=[];for(var t=sn()%yt;t<nt;)V&&!Nt&&nt<t+yt&&(t=nt-yt),De.push(t),t+=yt;(Nt&&De.length*yt<nt||!Nt&&0<De[0])&&De.unshift(0)}(),De!==Be&&(Ti(ke,function(t,e){De.indexOf(e)<0?Li(t):Si(t)}),Be=De))}function vi(t){return{container:$,slideItems:et,navContainer:Oe,navItems:ke,controlsContainer:Te,hasControls:fe,prevButton:Ee,nextButton:Me,items:yt,slideBy:xt,cloneCount:It,slideCount:nt,slideCountNew:Pt,index:Ft,indexCached:Vt,navCurrentIndex:Se,navCurrentIndexCached:Ie,visibleNavIndexes:De,visibleNavIndexesCached:Be,sheet:Dt,event:t||{}}}I&&console.warn("No slides found in",C.container)};return qi}();

//zoom
(function(window){
    function define_library() {
        var vanillaZoom = {};
        vanillaZoom.init = function(el) {

            var container = document.querySelector(el);

            // Change the selected image to be zoomed when clicking on the previews.
            container.addEventListener("click", function (event) {
                var elem = event.target;

                if (elem.classList.contains("small-preview")) {
                    var imageSrc = elem.src;
                    var imageWidth = elem.clientWidth;
                    var imageHeight = elem.clientHeight;
                    var newEl = document.createElement('div');
                    newEl.className = 'zoomed-image';
                    newEl.style.width = imageWidth+'px';
                    newEl.style.height = imageHeight+'px';
                    newEl.style.backgroundImage = 'url('+ imageSrc +')';
                    newEl.setAttribute('data-src', imageSrc);
                    elem.parentNode.replaceChild(newEl, elem);

                    newEl.addEventListener('click', function(e){
                      var imgEl = e.target;
                      var imageSrc = imgEl.getAttribute('data-src');
                      var newEl = document.createElement('img');
                      newEl.className = 'img-gallery small-preview';
                      newEl.src = imageSrc;
                      imgEl.parentNode.replaceChild(newEl, imgEl);

                     

                    });

                    newEl.addEventListener('mouseenter', function(e) {
                        this.style.backgroundSize = "250%"; 
                    }, false);


                    // Show different parts of image depending on cursor position.
                    newEl.addEventListener('mousemove', function(e) {
                        
                        // getBoundingClientReact gives us various information about the position of the element.
                        var dimentions = this.getBoundingClientRect();

                        // Calculate the position of the cursor inside the element (in pixels).
                        var x = e.clientX - dimentions.left;
                        var y = e.clientY - dimentions.top;

                        // Calculate the position of the cursor as a percentage of the total width/height of the element.
                        var xpercent = Math.round(100 / (dimentions.width / x));
                        var ypercent = Math.round(100 / (dimentions.height / y));

                        // Update the background position of the image.
                        this.style.backgroundPosition = xpercent+'% ' + ypercent+'%';
                    
                    }, false);


                    // When leaving the container zoom out the image back to normal size.
                    newEl.addEventListener('mouseleave', function(e) {
                        this.style.backgroundSize = "cover"; 
                        this.style.backgroundPosition = "center"; 
                    }, false);

                }
            });
            

        }
        return vanillaZoom;
    }

    // Add the vanillaZoom object to global scope.
    if(typeof(vanillaZoom) === 'undefined') {
        window.vanillaZoom = define_library();
    }
    else{
        console.log("Library already defined.");
    }
})(window);

/*!function(){"use strict";var t=function(t){this.input=null,this.inputDisplay=null,this.slider=null,this.sliderWidth=0,this.sliderLeft=0,this.pointerWidth=0,this.pointerR=null,this.pointerL=null,this.activePointer=null,this.selected=null,this.scale=null,this.step=0,this.tipL=null,this.tipR=null,this.timeout=null,this.valRange=!1,this.values={start:null,end:null},this.conf={target:null,values:null,set:null,range:!1,width:null,scale:!0,labels:!0,tooltip:!0,step:null,disabled:!1,onChange:null},this.cls={container:"rs-container",background:"rs-bg",selected:"rs-selected",pointer:"rs-pointer",scale:"rs-scale",noscale:"rs-noscale",tip:"rs-tooltip"};for(var i in this.conf)t.hasOwnProperty(i)&&(this.conf[i]=t[i]);this.init()};t.prototype.init=function(){return"object"==typeof this.conf.target?this.input=this.conf.target:this.input=document.getElementById(this.conf.target.replace("#","")),this.input?(this.inputDisplay=getComputedStyle(this.input,null).display,this.input.style.display="none",this.valRange=!(this.conf.values instanceof Array),!this.valRange||this.conf.values.hasOwnProperty("min")&&this.conf.values.hasOwnProperty("max")?this.createSlider():console.log("Missing min or max value...")):console.log("Cannot find target element...")},t.prototype.createSlider=function(){return this.slider=i("div",this.cls.container),this.slider.innerHTML='<div class="rs-bg"></div>',this.selected=i("div",this.cls.selected),this.pointerL=i("div",this.cls.pointer,["dir","left"]),this.scale=i("div",this.cls.scale),this.conf.tooltip&&(this.tipL=i("div",this.cls.tip),this.tipR=i("div",this.cls.tip),this.pointerL.appendChild(this.tipL)),this.slider.appendChild(this.selected),this.slider.appendChild(this.scale),this.slider.appendChild(this.pointerL),this.conf.range&&(this.pointerR=i("div",this.cls.pointer,["dir","right"]),this.conf.tooltip&&this.pointerR.appendChild(this.tipR),this.slider.appendChild(this.pointerR)),this.input.parentNode.insertBefore(this.slider,this.input.nextSibling),this.conf.width&&(this.slider.style.width=parseInt(this.conf.width)+"px"),this.sliderLeft=this.slider.getBoundingClientRect().left,this.sliderWidth=this.slider.clientWidth,this.pointerWidth=this.pointerL.clientWidth,this.conf.scale||this.slider.classList.add(this.cls.noscale),this.setInitialValues()},t.prototype.setInitialValues=function(){if(this.disabled(this.conf.disabled),this.valRange&&(this.conf.values=s(this.conf)),this.values.start=0,this.values.end=this.conf.range?this.conf.values.length-1:0,this.conf.set&&this.conf.set.length&&n(this.conf)){var t=this.conf.set;this.conf.range?(this.values.start=this.conf.values.indexOf(t[0]),this.values.end=this.conf.set[1]?this.conf.values.indexOf(t[1]):null):this.values.end=this.conf.values.indexOf(t[0])}return this.createScale()},t.prototype.createScale=function(t){this.step=this.sliderWidth/(this.conf.values.length-1);for(var e=0,s=this.conf.values.length;e<s;e++){var n=i("span"),l=i("ins");n.appendChild(l),this.scale.appendChild(n),n.style.width=e===s-1?0:this.step+"px",this.conf.labels?l.innerHTML=this.conf.values[e]:0!==e&&e!==s-1||(l.innerHTML=this.conf.values[e]),l.style.marginLeft=l.clientWidth/2*-1+"px"}return this.addEvents()},t.prototype.updateScale=function(){this.step=this.sliderWidth/(this.conf.values.length-1);for(var t=this.slider.querySelectorAll("span"),i=0,e=t.length;i<e;i++)t[i].style.width=this.step+"px";return this.setValues()},t.prototype.addEvents=function(){var t=this.slider.querySelectorAll("."+this.cls.pointer),i=this.slider.querySelectorAll("span");e(document,"mousemove touchmove",this.move.bind(this)),e(document,"mouseup touchend touchcancel",this.drop.bind(this));for(var s=0,n=t.length;s<n;s++)e(t[s],"mousedown touchstart",this.drag.bind(this));for(var s=0,n=i.length;s<n;s++)e(i[s],"click",this.onClickPiece.bind(this));return window.addEventListener("resize",this.onResize.bind(this)),this.setValues()},t.prototype.drag=function(t){if(t.preventDefault(),!this.conf.disabled){var i=t.target.getAttribute("data-dir");return"left"===i&&(this.activePointer=this.pointerL),"right"===i&&(this.activePointer=this.pointerR),this.slider.classList.add("sliding")}},t.prototype.move=function(t){if(this.activePointer&&!this.conf.disabled){var i=("touchmove"===t.type?t.touches[0].clientX:t.pageX)-this.sliderLeft-this.pointerWidth/2;return(i=Math.round(i/this.step))<=0&&(i=0),i>this.conf.values.length-1&&(i=this.conf.values.length-1),this.conf.range?(this.activePointer===this.pointerL&&(this.values.start=i),this.activePointer===this.pointerR&&(this.values.end=i)):this.values.end=i,this.setValues()}},t.prototype.drop=function(){this.activePointer=null},t.prototype.setValues=function(t,i){var e=this.conf.range?"start":"end";return t&&this.conf.values.indexOf(t)>-1&&(this.values[e]=this.conf.values.indexOf(t)),i&&this.conf.values.indexOf(i)>-1&&(this.values.end=this.conf.values.indexOf(i)),this.conf.range&&this.values.start>this.values.end&&(this.values.start=this.values.end),this.pointerL.style.left=this.values[e]*this.step-this.pointerWidth/2+"px",this.conf.range?(this.conf.tooltip&&(this.tipL.innerHTML=this.conf.values[this.values.start],this.tipR.innerHTML=this.conf.values[this.values.end]),this.input.value=this.conf.values[this.values.start]+","+this.conf.values[this.values.end],this.pointerR.style.left=this.values.end*this.step-this.pointerWidth/2+"px"):(this.conf.tooltip&&(this.tipL.innerHTML=this.conf.values[this.values.end]),this.input.value=this.conf.values[this.values.end]),this.values.end>this.conf.values.length-1&&(this.values.end=this.conf.values.length-1),this.values.start<0&&(this.values.start=0),this.selected.style.width=(this.values.end-this.values.start)*this.step+"px",this.selected.style.left=this.values.start*this.step+"px",this.onChange()},t.prototype.onClickPiece=function(t){if(!this.conf.disabled){var i=Math.round((t.clientX-this.sliderLeft)/this.step);return i>this.conf.values.length-1&&(i=this.conf.values.length-1),i<0&&(i=0),this.conf.range&&i-this.values.start<=this.values.end-i?this.values.start=i:this.values.end=i,this.slider.classList.remove("sliding"),this.setValues()}},t.prototype.onChange=function(){var t=this;this.timeout&&clearTimeout(this.timeout),this.timeout=setTimeout(function(){if(t.conf.onChange&&"function"==typeof t.conf.onChange)return t.conf.onChange(t.input.value)},500)},t.prototype.onResize=function(){return this.sliderLeft=this.slider.getBoundingClientRect().left,this.sliderWidth=this.slider.clientWidth,this.updateScale()},t.prototype.disabled=function(t){this.conf.disabled=t,this.slider.classList[t?"add":"remove"]("disabled")},t.prototype.getValue=function(){return this.input.value},t.prototype.destroy=function(){this.input.style.display=this.inputDisplay,this.slider.remove()};var i=function(t,i,e){var s=document.createElement(t);return i&&(s.className=i),e&&2===e.length&&s.setAttribute("data-"+e[0],e[1]),s},e=function(t,i,e){for(var s=i.split(" "),n=0,l=s.length;n<l;n++)t.addEventListener(s[n],e)},s=function(t){var i=[],e=t.values.max-t.values.min;if(!t.step)return console.log("No step defined..."),[t.values.min,t.values.max];for(var s=0,n=e/t.step;s<n;s++)i.push(t.values.min+s*t.step);return i.indexOf(t.values.max)<0&&i.push(t.values.max),i},n=function(t){return!t.set||t.set.length<1?null:t.values.indexOf(t.set[0])<0?null:!t.range||!(t.set.length<2||t.values.indexOf(t.set[1])<0)||null};window.rSlider=t}();
*/

!function() {
    "use strict";
    var a = function(a) {
        this.input = null, this.inputDisplay = null, this.slider = null, this.sliderWidth = 0, 
        this.sliderLeft = 0, this.pointerWidth = 0, this.pointerR = null, this.pointerL = null, 
        this.activePointer = null, this.selected = null, this.scale = null, this.step = 0, 
        this.tipL = null, this.tipR = null, this.timeout = null, this.timeout2 = null, this.leftval = null,
        this.rightval = null,
         this.valRange = !1, this.values = {
            start: null,
            end: null
        }, this.conf = {
            target: null,
            values: null,
            set: null,
            range: !1,
            width: null,
            scale: !0,
            labels: !0,
            tooltip: !0,
            step: null,
            disabled: !1,
            onChange: null
        }, this.cls = {
            container: "rs-container",
            background: "rs-bg",
            selected: "rs-selected",
            pointer: "rs-pointer",
            scale: "rs-scale",
            noscale: "rs-noscale",
            tip: "rs-tooltip"
        };
        for (var b in this.conf) a.hasOwnProperty(b) && (this.conf[b] = a[b]);
        this.init();
    };
    a.prototype.init = function() {
        return "object" == typeof this.conf.target ? this.input = this.conf.target : this.input = document.getElementById(this.conf.target.replace("#", "")), 
        this.input ? (this.inputDisplay = getComputedStyle(this.input, null).display, this.input.style.display = "none", 
        this.leftval = document.getElementById('price-slider-from'),
        this.rightval = document.getElementById('price-slider-to'),
        this.valRange = !(this.conf.values instanceof Array), !this.valRange || this.conf.values.hasOwnProperty("min") && this.conf.values.hasOwnProperty("max") ? this.createSlider() : console.log("Missing min or max value...")) : console.log("Cannot find target element...");
    }, a.prototype.createSlider = function() {
        return this.slider = b("div", this.cls.container), this.slider.innerHTML = '<div class="rs-bg"></div>', 
        this.selected = b("div", this.cls.selected), this.pointerL = b("div", this.cls.pointer, [ "dir", "left" ]), 
        this.scale = b("div", this.cls.scale), this.conf.tooltip && (this.tipL = b("div", this.cls.tip), 
        this.tipR = b("div", this.cls.tip), this.pointerL.appendChild(this.tipL)), this.slider.appendChild(this.selected), 
        this.slider.appendChild(this.scale), this.slider.appendChild(this.pointerL), this.conf.range && (this.pointerR = b("div", this.cls.pointer, [ "dir", "right" ]), 
        this.conf.tooltip && this.pointerR.appendChild(this.tipR), this.slider.appendChild(this.pointerR)), 
        this.input.parentNode.insertBefore(this.slider, this.input.nextSibling), this.conf.width && (this.slider.style.width = parseInt(this.conf.width) + "px"), 
        this.sliderLeft = this.slider.getBoundingClientRect().left, this.sliderWidth = this.slider.clientWidth, 
        this.pointerWidth = this.pointerL.clientWidth, this.conf.scale || this.slider.classList.add(this.cls.noscale), 
        this.setInitialValues();
    }, a.prototype.setInitialValues = function() {
      console.log('inia111', this.conf);
        if (this.disabled(this.conf.disabled), this.valRange && (this.conf.values = d(this.conf)), 
        this.values.start = 0, this.values.end = this.conf.range ? this.conf.values.length - 1 : 0, 
        this.conf.set && this.conf.set.length && e(this.conf)) {
            var a = this.conf.set;
            console.log('inia', a);
            this.conf.range ? (this.values.start = this.conf.values.indexOf(a[0]), this.values.end = this.conf.set[1] ? this.conf.values.indexOf(a[1]) : null) : this.values.end = this.conf.values.indexOf(a[0]);
        }
        this.leftval.innerHTML = this.conf.values[this.values.start].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        this.rightval.innerHTML = this.conf.values[this.values.end].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        return this.createScale();
    }, a.prototype.createScale = function(a) {
        this.step = this.sliderWidth / (this.conf.values.length - 1);
        for (var c = 0, d = this.conf.values.length; c < d; c++) {
            var e = b("span"), f = b("ins");
            e.appendChild(f), this.scale.appendChild(e), e.style.width = c === d - 1 ? 0 : this.step + "px", 
            this.conf.labels ? f.innerHTML = this.conf.values[c] : 0 !== c && c !== d - 1 || (f.innerHTML = this.conf.values[c]), 
            f.style.marginLeft = f.clientWidth / 2 * -1 + "px";
        }
        return this.addEvents();
    }, a.prototype.updateScale = function() {
        this.step = this.sliderWidth / (this.conf.values.length - 1);
        for (var a = this.slider.querySelectorAll("span"), b = 0, c = a.length; b < c; b++) a[b].style.width = this.step + "px";
        return this.setValues();
    }, a.prototype.addEvents = function() {
        var a = this.slider.querySelectorAll("." + this.cls.pointer), b = this.slider.querySelectorAll("span");
        c(document, "mousemove touchmove", this.move.bind(this)), c(document, "mouseup touchend touchcancel", this.drop.bind(this));
        for (var d = 0, e = a.length; d < e; d++) c(a[d], "mousedown touchstart", this.drag.bind(this));
        for (var d = 0, e = b.length; d < e; d++) c(b[d], "click", this.onClickPiece.bind(this));
        return window.addEventListener("resize", this.onResize.bind(this)), this.setValues();
    }, a.prototype.drag = function(a) {
        if (a.preventDefault(), !this.conf.disabled) {
            var b = a.target.getAttribute("data-dir");
            return "left" === b && (this.activePointer = this.pointerL), "right" === b && (this.activePointer = this.pointerR), 
            this.slider.classList.add("sliding");
        }
    }, a.prototype.move = function(a) {
        if (this.activePointer && !this.conf.disabled) {
            var b = ("touchmove" === a.type ? a.touches[0].clientX : a.pageX) - this.sliderLeft - this.pointerWidth / 2,
                tttb = this;
            this.leftval.innerHTML = tttb.conf.values[tttb.values.start].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            this.rightval.innerHTML = tttb.conf.values[tttb.values.end].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            return (b = Math.round(b / this.step)) <= 0 && (b = 0), b > this.conf.values.length - 1 && (b = this.conf.values.length - 1), 
            this.conf.range ? (this.activePointer === this.pointerL && (this.values.start = b), 
            this.activePointer === this.pointerR && (this.values.end = b)) : this.values.end = b, 
/*            this.timeout2 && clearTimeout(this.timeout2), this.timeout2 = setTimeout(function() {
                  console.log(tttb.conf.values[tttb.values.start], tttb.conf.values[tttb.values.end])
            }, 10),*/
            this.setValues();
        }
    }, a.prototype.drop = function() {
        this.activePointer = null;
    }, a.prototype.setValues = function(a, b) {
        var c = this.conf.range ? "start" : "end";
        return a && this.conf.values.indexOf(a) > -1 && (this.values[c] = this.conf.values.indexOf(a)), 
        b && this.conf.values.indexOf(b) > -1 && (this.values.end = this.conf.values.indexOf(b)), 
        this.conf.range && this.values.start > this.values.end && (this.values.start = this.values.end), 
        this.pointerL.style.left = this.values[c] * this.step + "px", 
            this.leftval.innerHTML = this.conf.values[this.values.start].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "),
            this.rightval.innerHTML = this.conf.values[this.values.end].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "),
        this.conf.range ? (this.conf.tooltip && (this.tipL.innerHTML = this.conf.values[this.values.start], 
        this.tipR.innerHTML = this.conf.values[this.values.end]), this.input.value = this.conf.values[this.values.start] + "," + this.conf.values[this.values.end], 
        this.pointerR.style.left = this.values.end * this.step + "px") : (this.conf.tooltip && (this.tipL.innerHTML = this.conf.values[this.values.end]), 
        this.input.value = this.conf.values[this.values.end]), this.values.end > this.conf.values.length - 1 && (this.values.end = this.conf.values.length - 1), 
        this.values.start < 0 && (this.values.start = 0), this.selected.style.width = (this.values.end - this.values.start) * this.step + "px", 
        this.selected.style.left = this.values.start * this.step + "px", this.onChange();
    }, a.prototype.onClickPiece = function(a) {
        if (!this.conf.disabled) {
            var b = Math.round((a.clientX - this.sliderLeft) / this.step);
            return b > this.conf.values.length - 1 && (b = this.conf.values.length - 1), b < 0 && (b = 0), 
            this.conf.range && b - this.values.start <= this.values.end - b ? this.values.start = b : this.values.end = b, 
            this.slider.classList.remove("sliding"), this.setValues();
        }
    }, a.prototype.onChange = function() {
        var a = this;
        this.timeout && clearTimeout(this.timeout), this.timeout = setTimeout(function() {
            if (a.conf.onChange && "function" == typeof a.conf.onChange) return a.conf.onChange(a.input.value);
        }, 1000);
    }, a.prototype.onResize = function() {
        return this.sliderLeft = this.slider.getBoundingClientRect().left, this.sliderWidth = this.slider.clientWidth, 
        this.updateScale();
    }, a.prototype.disabled = function(a) {
        this.conf.disabled = a, this.slider.classList[a ? "add" : "remove"]("disabled");
    }, a.prototype.getValue = function() {
        return this.input.value;
    }, a.prototype.destroy = function() {
        this.input.style.display = this.inputDisplay, this.slider.remove();
    };
    var b = function(a, b, c) {
        var d = document.createElement(a);
        return b && (d.className = b), c && 2 === c.length && d.setAttribute("data-" + c[0], c[1]), 
        d;
    }, c = function(a, b, c) {
        for (var d = b.split(" "), e = 0, f = d.length; e < f; e++) a.addEventListener(d[e], c);
    }, d = function(a) {
        var b = [], c = a.values.max - a.values.min;
        if (!a.step) return console.log("No step defined..."), [ a.values.min, a.values.max ];
        for (var d = 0, e = c / a.step; d < e; d++) b.push(a.values.min + d * a.step);
        return b.indexOf(a.values.max) < 0 && b.push(a.values.max), b;
    }, e = function(a) {
        return !a.set || a.set.length < 1 ? null : a.values.indexOf(a.set[0]) < 0 ? null : !a.range || !(a.set.length < 2 || a.values.indexOf(a.set[1]) < 0) || null;
    };
    window.rSlider = a;
}();

//vanillaZoom.init('#my-gallery');


//lazy
var _extends=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e[o]=n[o])}return e},_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};!function(e,t){"object"===("undefined"==typeof exports?"undefined":_typeof(exports))&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.LazyLoad=t()}(this,function(){"use strict";var _=!("onscroll"in window)||/glebot/.test(navigator.userAgent),f=function(e,t){e&&e(t)},o=function(e){return e.getBoundingClientRect().top+window.pageYOffset-e.ownerDocument.documentElement.clientTop},p=function(e,t,n){return(t===window?window.innerHeight+window.pageYOffset:o(t)+t.offsetHeight)<=o(e)-n},i=function(e){return e.getBoundingClientRect().left+window.pageXOffset-e.ownerDocument.documentElement.clientLeft},m=function(e,t,n){var o=window.innerWidth;return(t===window?o+window.pageXOffset:i(t)+o)<=i(e)-n},g=function(e,t,n){return(t===window?window.pageYOffset:o(t))>=o(e)+n+e.offsetHeight},v=function(e,t,n){return(t===window?window.pageXOffset:i(t))>=i(e)+n+e.offsetWidth};var s=function(e,t){var n,o="LazyLoad::Initialized",i=new e(t);try{n=new CustomEvent(o,{detail:{instance:i}})}catch(e){(n=document.createEvent("CustomEvent")).initCustomEvent(o,!1,!1,{instance:i})}window.dispatchEvent(n)};var w="data-",u=function(e,t){return e.getAttribute(w+t)},d=function(e,t,n){for(var o,i=0;o=e.children[i];i+=1)if("SOURCE"===o.tagName){var s=u(o,n);s&&o.setAttribute(t,s)}},h=function(e,t,n){n&&e.setAttribute(t,n)};var e="undefined"!=typeof window,n=e&&"classList"in document.createElement("p"),b=function(e,t){n?e.classList.add(t):e.className+=(e.className?" ":"")+t},l=function(e,t){n?e.classList.remove(t):e.className=e.className.replace(new RegExp("(^|\\s+)"+t+"(\\s+|$)")," ").replace(/^\s+/,"").replace(/\s+$/,"")},t=function(e){this._settings=_extends({},{elements_selector:"img",container:window,threshold:300,throttle:150,data_src:"src",data_srcset:"srcset",data_sizes:"sizes",class_loading:"loading",class_loaded:"loaded",class_error:"error",class_initial:"initial",skip_invisible:!0,callback_load:null,callback_error:null,callback_set:null,callback_processed:null,callback_enter:null},e),this._queryOriginNode=this._settings.container===window?document:this._settings.container,this._previousLoopTime=0,this._loopTimeout=null,this._boundHandleScroll=this.handleScroll.bind(this),this._isFirstLoop=!0,window.addEventListener("resize",this._boundHandleScroll),this.update()};t.prototype={_reveal:function(t){var n=this._settings,o=function e(){n&&(t.removeEventListener("load",i),t.removeEventListener("error",e),l(t,n.class_loading),b(t,n.class_error),f(n.callback_error,t))},i=function e(){n&&(l(t,n.class_loading),b(t,n.class_loaded),t.removeEventListener("load",e),t.removeEventListener("error",o),f(n.callback_load,t))};f(n.callback_enter,t),-1<["IMG","IFRAME","VIDEO"].indexOf(t.tagName)&&(t.addEventListener("load",i),t.addEventListener("error",o),b(t,n.class_loading)),function(e,t){var n=t.data_sizes,o=t.data_srcset,i=t.data_src,s=u(e,i),l=e.tagName;if("IMG"===l){var r=e.parentNode;r&&"PICTURE"===r.tagName&&d(r,"srcset",o);var a=u(e,n);h(e,"sizes",a);var c=u(e,o);return h(e,"srcset",c),h(e,"src",s)}if("IFRAME"!==l)return"VIDEO"===l?(d(e,"src",i),h(e,"src",s)):s&&(e.style.backgroundImage='url("'+s+'")');h(e,"src",s)}(t,n),f(n.callback_set,t)},_loopThroughElements:function(e){var t,n,o,i,s,l=this._settings,r=this._elements,a=r?r.length:0,c=void 0,u=[],d=this._isFirstLoop;for(c=0;c<a;c++){var h=r[c];l.skip_invisible&&null===h.offsetParent||(!_&&!e&&(o=h,i=l.container,s=l.threshold,p(o,i,s)||g(o,i,s)||m(o,i,s)||v(o,i,s))||(d&&b(h,l.class_initial),this._reveal(h),u.push(c),t="was-processed",n=!0,h.setAttribute(w+t,n)))}for(;u.length;)r.splice(u.pop(),1),f(l.callback_processed,r.length);0===a&&this._stopScrollHandler(),d&&(this._isFirstLoop=!1)},_purgeElements:function(){var e=this._elements,t=e.length,n=void 0,o=[];for(n=0;n<t;n++){var i=e[n];u(i,"was-processed")&&o.push(n)}for(;0<o.length;)e.splice(o.pop(),1)},_startScrollHandler:function(){this._isHandlingScroll||(this._isHandlingScroll=!0,this._settings.container.addEventListener("scroll",this._boundHandleScroll))},_stopScrollHandler:function(){this._isHandlingScroll&&(this._isHandlingScroll=!1,this._settings.container.removeEventListener("scroll",this._boundHandleScroll))},handleScroll:function(){var e=this._settings.throttle;if(0!==e){var t=Date.now(),n=e-(t-this._previousLoopTime);n<=0||e<n?(this._loopTimeout&&(clearTimeout(this._loopTimeout),this._loopTimeout=null),this._previousLoopTime=t,this._loopThroughElements()):this._loopTimeout||(this._loopTimeout=setTimeout(function(){this._previousLoopTime=Date.now(),this._loopTimeout=null,this._loopThroughElements()}.bind(this),n))}else this._loopThroughElements()},loadAll:function(){this._loopThroughElements(!0)},update:function(){this._elements=Array.prototype.slice.call(this._queryOriginNode.querySelectorAll(this._settings.elements_selector)),this._purgeElements(),this._loopThroughElements(),this._startScrollHandler()},destroy:function(){window.removeEventListener("resize",this._boundHandleScroll),this._loopTimeout&&(clearTimeout(this._loopTimeout),this._loopTimeout=null),this._stopScrollHandler(),this._elements=null,this._queryOriginNode=null,this._settings=null}};var r=window.lazyLoadOptions;return e&&r&&function(e,t){var n=t.length;if(n)for(var o=0;o<n;o++)s(e,t[o]);else s(e,t)}(t,r),t});