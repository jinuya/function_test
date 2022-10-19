class Store {
    constructor() {
        this.list = [];
        this.maplist = {};
        this.store_list = document.querySelector("#store_list");
        this.cho = ["ㄱ","ㄲ",'ㄴ','ㄷ',"ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ",'ㅈ',"ㅉ","ㅊ",'ㅋ','ㅌ',"ㅍ","ㅎ"];
        this.drop_area = document.querySelector("#drop_box_area");
        this.startPoint = null;
        this.basketList = [];
        this.basket_list = document.querySelector("#basket_list");
        this.basket_price = document.querySelector("#basket_price");
        this.data = null;
        
        document.querySelector("#search_form").addEventListener("keyup",this.search);
        document.querySelector("#search_btn").addEventListener("click",this.search);
        this.drop_area.addEventListener("dragover",this.dragover);
        document.querySelector("#basket_sell").addEventListener("click",this.basketformreset);
        document.querySelector("#basket_sell_btn").addEventListener("click",this.recepit);

        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setting(data))

        this.setEvent();
    }
    
    setEvent() {

        window.addEventListener("mousemove",e=> {
            if(this.startPoint === null) return false;
            let x = e.clientX, y = e.clientY;
            $(".moveCard").css("left",x-50+"px");
            $(".moveCard").css("top",y-50+"px");
            
        });
        
        window.addEventListener("mouseup",e=> {
            let dropBox = this.drop_area.getBoundingClientRect();
            let dropStartX = dropBox.x
            let dropStartY = dropBox.y
            let dropEndX = dropBox.x + dropBox.width;
            let dropEndY = dropBox.y + dropBox.height;
            
            let target = document.querySelector(".moveCard");
            
            if(this.startPoint === null) return false;
            let sx = this.startPoint[0],sy = this.startPoint[1];
            this.startPoint = null;
            let id = target.getAttribute("data-id");
            let x = e.clientX, y = e.clientY;

            if(dropStartX < x && dropEndX > x && dropStartY < y && dropEndY > y) {
                let flag = false;
                this.basketList.find((x)=>{if(x == id) flag = true;});
                
                if(flag) {
                    $(".moveCard").css("transition","0.3s");
                    $(".moveCard").css("left",sx+"px");
                    $(".moveCard").css("top",sy+"px");
                    $(".moveCard").css("opacity",0);
                    
                    this.startPoint = null;
                    alert("이미 장바구니에 담긴 상품입니다.");
                    
                    setTimeout(()=>{
                        $(".moveCard").css("transition","none");
                        $(".moveCard").css("left",0);
                        $(".moveCard").css("top",0);
                        $(".moveCard").css("opacity",1);
                        target.classList.remove("moveCard");
                    },300);
                    return false;
                }
                
                $(".moveCard").css("left",0);
                $(".moveCard").css("top",0);
                target.classList.remove("moveCard");
                this.basketList.push(id);
                this.startPoint = null;
                this.MakeBasketItem();
            } else {
                $(".moveCard").css("transition","0.3s");
                $(".moveCard").css("left",sx+"px");
                $(".moveCard").css("top",sy+"px");
                $(".moveCard").css("opacity",0);
                
                setTimeout(()=> {
                    $(".moveCard").css("transition","none");
                    $(".moveCard").css("left",0);
                    $(".moveCard").css("top",0);
                    $(".moveCard").css("opacity",1);
                    target.classList.remove("moveCard");
                },300);
            }
        })
    }
    
    setting(data){
        this.data = data;
        this.store_list.innerHTML = "";
        data.forEach(x=>{
            x.price_num = parseInt(x.price.replace(/,/g,""));
            x.num = 1;
            this.MakeStoreItem(x);
        });
        this.list = data;
        this.maplist = data.reduce((r,s)=>({...r,[s.id]:s}),{});
        this.basket_price.innerHTML = "0";
        this.basket_list.innerHTML = "";
        this.basketList = [];
    }
    
    basketformreset(){
        const form = document.basket_form;
        form.name.value = "";
        form.port.value = "";
    }
    
    search=e=>{
        let target = document.querySelector("#search_form");
        this.store_list.innerHTML = "";
        let keyword = target.value,list = [];
        if(keyword.length == 0) this.list.forEach(x=>{this.MakeStoreItem(x);});
        else{
            this.list.forEach(x=>{
                let {id,photo,product_name,brand,price,price_num,num} = x;
                let p_idx = this.match(keyword,product_name);
                if(p_idx !== -1) product_name = product_name.substr(0,p_idx)+"<mark>"+product_name.substr(p_idx,keyword.length)+"</mark>"+product_name.substr(p_idx+keyword.length,product_name.length);
                let b_idx = this.match(keyword,brand);
                if(b_idx !== -1) brand = brand.substr(0,b_idx)+"<mark>"+brand.substr(b_idx,keyword.length)+"</mark>"+brand.substr(b_idx+keyword.length,brand.length);
                if(b_idx !== -1 || p_idx !== -1) list.push({id,photo,product_name,brand,price,price_num,num});
            });
            if(list.length == 0) this.store_list.innerHTML = "<p id='now_search'>일치하는 상품이 없습니다.</p>";
            else list.forEach(x=>{this.MakeStoreItem(x);});
        }
    }
    
    match(keyword,word){
        let cho = this.getCho(word),flag = false,result = "";
        for(let i =0; i<keyword.length;i++) this.cho.find((x)=>{if(x == keyword[i])flag =true;});
        if(flag) result = cho.indexOf(keyword);
        else result = word.indexOf(keyword);
        return result;
    }
    
    getCho(word){
        let result = "";
        for(let i = 0; i<word.length;i++){
            let idx = Math.floor((word[i].charCodeAt() - 44032)/588);
            result += (this.cho[idx] || word[i]);
        }
        return result;
    }
    
    MakeStoreItem({id,photo,product_name,brand,price}){
        let dom = document.createElement("div");
        dom.innerHTML = `<div class="card store_card">
                            <div class="card-img-box">
                                <img src="resources/images/${photo}" data-id="${id}" alt="store_img" title='store_img' class="card-img">
                                <img src="resources/images/${photo}" data-id="${id}" alt="store_img" title='store_img' class="card-img move">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">${product_name}</h5>
                                <p class="card-subtitle text-muted">${brand}</p>
                                <p class="card-text text-right">${price}원</p>
                            </div>
                         </div>`;
        dom.firstChild.querySelector("img.move").addEventListener("dragstart",this.dragStart);
        
        this.store_list.appendChild(dom.firstChild);
    }

    dragover=e=>{e.preventDefault();}
    
    dragStart=e=>{
        if(document.querySelector(".moveCard")) document.querySelector(".moveCard").classList.remove("moveCard");
        e.preventDefault();
        if(this.startPoint !== null) return false;
        let id = e.target.getAttribute("data-id");
        e.dataTransfer.setData("id",id);
        
        let x = e.clientX, y = e.clientY;
        this.startPoint = [x,y];

        e.target.classList.add("moveCard");
        $(e.target).css("top",y-50+"px");
        $(e.target).css("left",x-50+"px");
    }
    
    MakeBasketItem(){
        this.basket_list.innerHTML = "";
        this.basketList.forEach((x,idx)=>{
            let item = this.maplist[x];
            let dom = document.createElement("tr");
            dom.innerHTML =`<td>${idx+1}</td>
            <td><img src="resources/images/${item.photo}" title="basket_img" alt="basket_img" draggable="false" class="basket_img"></td>
            <td>${item.product_name}</td>
            <td>${item.brand}</td>
            <td>${item.price}원</td>
            <td id="basket_num"><input type="number" min="1" data-id="${item.id}" value="${item.num}" class="basket_num form-control w-100"></td>
            <td>${(item.num * item.price_num).toLocaleString()}원</td>
            <td><button class="basket_del float-right" data-id="${idx}">&times;</button></td>`;
            dom.querySelector(".basket_num").addEventListener("change",this.basketNum);
            dom.querySelector(".basket_del").addEventListener("click",this.basketDel);
            this.basket_list.appendChild(dom);
            
        });
        this.basketprice();
    }
    
    basketprice(){
        let sum = 0;
        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            sum += (item.price_num * item.num);
        });
        this.basket_price.innerHTML = sum.toLocaleString();
    }

    basketNum=e=>{
        let target = e.target, val = target.value,idx = target.getAttribute("data-id");
        val = parseInt(val);
        if(val < 1 || isNaN(val)) val = 1;
        this.maplist[idx].num = val;
        this.MakeBasketItem();
    }

    basketDel=e=>{
        let idx = e.target.getAttribute("data-id");
        this.basketList.splice(idx,1);
        this.MakeBasketItem();
    }

    recepit=e=>{
        const form = document.basket_form;
        if(form.name.value == "" || form.port.value == "") return alert("내용을 입력해주세요.");
        $("#basket_close").trigger("click");
        
        const canvas = document.querySelector("#recepit");
        const ctx = canvas.getContext("2d");
        
        let fontSize = 15,offset = 10,list = [],sum = 0,base = 100,maxproduct="",maxprice="",maxnum="",maxsum="",add_space = 0;
        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            item.sum = item.price_num * item.num;
            sum += item.sum;
            if(item.product_name.length > maxproduct.length) maxproduct = item.product_name;
            if(item.price.length > maxprice.length) maxprice = item.price;
            if((item.num+"").length > maxnum.length) maxnum = item.num+"";
            if((item.sum+"").length > maxsum.length) maxsum = item.sum+"";
            list.push(item);
        });
        
        let maxproductwidth = (maxproduct.length * fontSize),maxpricewidth = (maxprice.length * fontSize) , maxnumwidth = (maxnum.length * fontSize) , maxsumwidth = (maxsum.length * (fontSize+5));
        if(maxproductwidth + maxpricewidth + maxnumwidth + maxsumwidth + base + (fontSize * 5) < 400) add_space = (400 - (maxproductwidth + maxpricewidth + maxnumwidth + maxsumwidth + base + (fontSize * 5)));
        canvas.width = maxproductwidth + maxpricewidth + maxnumwidth + maxsumwidth + base + (fontSize * 6) + add_space;
        canvas.height = (list.length * (fontSize + offset)) + (fontSize * 8);
        ctx.font = fontSize+"px Arial";
        
        // 캔버스 시작;
        let top = offset + fontSize,left = offset;
        ctx.fillText("상품명",left,top);
        left += maxproductwidth + base + fontSize + offset;
        ctx.fillText("가격",left,top);
        left += maxpricewidth + fontSize + offset + offset;
        ctx.fillText("수량",left,top);
        left += maxnumwidth + fontSize + fontSize + offset ;
        ctx.fillText("합계",left,top);
        
        top += fontSize;
        
        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        list.forEach(item=>{
            top += offset + fontSize;
            left = offset;

            ctx.fillText(item.product_name,left,top);
            left += maxproductwidth + base + fontSize + offset;
            ctx.fillText(item.price+"원",left,top);
            left += maxpricewidth + fontSize + offset + offset;
            ctx.fillText(item.num+"개",left,top);
            left += maxnumwidth + fontSize + fontSize + offset ;
            ctx.fillText(item.sum.toLocaleString()+"원",left,top);

        });

        top += offset;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        let now = new Date();
        let time = (now+"").match(/[0-9]{2}:[0-9]{2}:[0-9]{2}/g)[0];
        top += fontSize + offset;
        ctx.fillText(`총합계 : ${sum.toLocaleString()}원`,offset,top);
        top += fontSize + offset;
        let info = `구매일시 : ${now.getFullYear()}-${now.getMonth()+1}-${now.getDate()} ${time}`;
        ctx.fillText(info,offset,top);

        $("#recepit_open").trigger("click");

        this.setting(this.data);
    }

}
    
window.onload=()=>{
    let store = new Store();
}