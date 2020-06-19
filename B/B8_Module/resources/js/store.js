class Store{
    constructor(){
        this.list = [];
        this.maplist = {};
        this.basket_list = document.querySelector("#basket_list");
        this.basketList = [];
        this.store_list = document.querySelector("#store_list");
        this.basket_price = document.querySelector("#basket_price_all");
        this.drop_area = document.querySelector("#drop_area");
        this.cho = ["ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ"];
        this.moveItem = null;
        this.drag_id = null;
        this.drag_target = null;

        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setting(data))
    }

    setting(data){
        data.forEach(x=>{
            x.price_num = parseInt(x.price.replace(/,/g,""));
            x.num = 1;
            this.MakeStoreItem(x);
        });
        this.list = data;
        this.maplist = this.list.reduce((r,s)=>({...r,[s.id]:s}),{});
        this.basket_price.innerHTML = "0";
        document.querySelector("#search_form").addEventListener("keyup",this.search);
        document.querySelector("#basket_sell_send").addEventListener("click",this.basketSell);
        document.querySelector("#basket_sell_btn").addEventListener("click",this.formReset);

        window.addEventListener("mousemove",this.draging);
        window.addEventListener("mouseup",this.drop);

    }

    formReset(){
        const form = document.basket_form;
        form.name.value = "";
        form.port.value = "";
    }

    search=e=>{
        this.store_list.innerHTML = "";
        let keyword = e.target.value,list = [];
        if(keyword.length == 0) this.list.forEach(x=>{this.MakeStoreItem(x)});
        else{
            this.list.forEach(x=>{
                let {id,photo,price,price_num,brand,product_name,num} = x;
                let p_idx = this.match(keyword,product_name);
                if(p_idx !== -1) product_name = product_name.substr(0,p_idx)+"<mark>"+product_name.substr(p_idx,keyword.length)+"</mark>"+product_name.substr(keyword.length+p_idx,product_name.length);
                let b_idx = this.match(keyword,brand);
                if(b_idx !== -1) brand = brand.substr(0,b_idx)+"<mark>"+brand.substr(b_idx,keyword.length)+"</mark>"+brand.substr(keyword.length+b_idx,brand.length);
                if(b_idx !== -1 || p_idx !== -1)list.push({id,photo,price,price_num,brand,product_name,num});
            });
            if(list.length == 0) this.store_list.innerHTML = `<p class="not_search text-white text-center">일치하는 상품이 없습니다.</p>`;
            else list.forEach(x=>{this.MakeStoreItem(x)});
        }
    }

    getCho(word){
        let result = "",idx=null;
        for(let i =0; i< word.length;i++){
            idx = Math.floor((word[i].charCodeAt() - 44032)/588);
            result += (this.cho[idx] || word[i]);            
        }
        return result;
    }

    match(keyword,word){
        let word_cho = this.getCho(word),result = "",flag = false;
        for(let i =0; i<keyword.length;i++) this.cho.find((x)=>{if(x == keyword[i])flag = true});
        if(flag)result = word_cho.indexOf(keyword);
        else result = word.indexOf(keyword);
        return result;
    }

    MakeStoreItem({id,photo,price,price_num,brand,product_name,num}){
        let dom = document.createElement("div");
        dom.innerHTML = `<div class="card store_card">
                            <div class="card-img card_img_box"><img src="resources/images/${photo}" data-id="${id}" alt="store_img" title="store_img" class="store_img" draggable="false" id = "store_img_${id}"></div>
                            <div class="card-body border-top">
                                <h5 class="card-title pb-2">${product_name}</h5>
                                <p class="card-subtitle pb-2 text-muted">${brand}</p>
                                <p class="card-text text-right pr-2">${price}원</p>
                            </div>
                        </div>`;
        dom.firstChild.querySelector("img").addEventListener("mousedown",this.drag);
        this.store_list.appendChild(dom.firstChild);
    }

    drop=e=>{
        $("#"+this.drag_target).css("visibility","visible");
        $("#drag_item_box").css("display","none");
        console.log(this.drag_target);
        // if(this.moveItem !==null && e.path[0].id == "drop_area" && this.drag_id !== null){
        //     let flag = true;
        //     console.log(this.drag_id);
        // }
        this.drag_id = null;
        this.moveItem = null;
    }

    draging=e=>{
        if(this.moveItem !== null){
            let x = e.clientX,y = e.clientY;
            $("#drag_item_box").css("top",(y-100)+"px");
            $("#drag_item_box").css("left",(x-100)+"px");
        }
    }

    drag=e=>{
        this.moveItem = true;
        let id = e.target.getAttribute("data-id"),x = e.clientX,y = e.clientY,target = e.target.id;
        this.drag_id = id;
        this.drag_target = target;
        console.log(target);
        $("#"+target).css("visibility","hidden");
        $("#drag_item_box").css("display","block");
        document.querySelector("#drag_item_box_img").setAttribute("src","resources/images/product_"+id+".jpg");
        $("#drag_item_box").css("top",(y-100)+"px");
        $("#drag_item_box").css("left",(x-100)+"px");
        $("#drag_item_box").css("z-index",200);
    }

    basketItmeMake=e=>{
        this.basket_list.innerHTML = "";
        this.basketList.forEach((x,idx)=>{
            let item = this.maplist[x];
            let dom = document.createElement("tr");
            dom.innerHTML = `<td>${idx+1}</td>
                             <td><img src="resources/images/${item.photo}" alt="basket_img" title="basket_title" class="basket_img" draggable="false"></td>
                             <td>${item.product_name}</td>
                             <td>${item.brand}</td>
                             <td>${item.price}원</td>
                             <td><input type="number" class="form-control w-50 basket_price" min="1" value="${item.num}" data-idx="${item.id}"></td>
                             <td>${(item.price_num * item.num).toLocaleString()}원</td>
                             <td><button class="basket_del float-right" data-id="${idx}">&times;</button></td>`;
            dom.querySelector(".basket_price").addEventListener("change",this.basketNum);
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

    basketDel=e=>{
        let id = e.target.getAttribute("data-id");
        this.basketList.splice(id,1);
        this.basketItmeMake();
    }

    basketNum=e=>{
        let target = e.target,val = e.target.value,id = e.target.getAttribute("data-idx");
        val = parseInt(val);
        if(val < 1 || isNaN(val)) val = 1;
        target.value = val;
        this.maplist[id].num = val;
        this.basketItmeMake();
    }

    basketSell=e=>{
        const form = document.basket_form;
        if(form.name.value == "" || form.port.value == "") return alert("내용을 입력해주세요.");
        if(this.basketList.length == 0) return alert("장바구니가 비어져있습니다."); 
        $("#basket_close").trigger("click");

        const canvas = document.querySelector("#recepit");
        const ctx = canvas.getContext("2d");

        let fontSize = 15,offset = 10,base_space = 200,maxproduct = "",maxprice = "", maxnum = "",maxsum = "",list = [],sum=0;

        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            item.sum = (item.price_num * item.num);
            sum += item.sum;
            if(item.product_name.length > maxproduct.length) maxproduct = item.product_name;
            if(item.price.length > maxprice.length) maxprice = item.price;
            if((item.num+"").length > maxnum.length) maxnum = item.num+"";
            if((item.sum+"").length > maxsum.length) maxsum = item.sum+"";
            list.push(item);
        });
        let maxproductwidth = maxproduct.length * fontSize, maxpricewidth = maxprice.length * fontSize,maxnumwidth = maxnum.length * fontSize,maxsumwidth = maxsum.length * fontSize;

        let width = (offset * 2) + maxproductwidth + maxpricewidth + maxnumwidth + maxsumwidth + base_space + (fontSize * 4);
        let height = (list.length * (offset + fontSize)) + (fontSize * 10);
        canvas.width = width;
        canvas.height = height;
        ctx.font = fontSize+"px Arial";

        let top = offset+offset, left = offset;

        ctx.fillText("상품명",left,top);
        left += maxproductwidth+base_space+fontSize+offset;
        ctx.fillText("가격",left,top);
        left += maxpricewidth+fontSize+offset;
        ctx.fillText("수량",left,top);
        left += maxnumwidth + fontSize + offset;
        ctx.fillText("합계",left,top);

        top += fontSize;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        list.forEach(x=>{
            left = offset;
            top += fontSize + offset;

            ctx.fillText(x.product_name,left,top);
            left += maxproductwidth+base_space+fontSize+offset;
            ctx.fillText(x.price+"원",left,top);
            left += maxpricewidth+fontSize+offset;
            ctx.fillText(x.num+"개",left,top);
            left += maxnumwidth + fontSize + offset;
            ctx.fillText(x.sum.toLocaleString()+"원",left,top);
        });

        top+=offset;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width-offset,top);
        ctx.stroke();

        let now = new Date();
        top += fontSize + offset;
        ctx.fillText(`총합계 : ${sum.toLocaleString()}원`,offset,top);
        top += fontSize + offset;
        let info = `구매일시 : ${now.getFullYear()}-${now.getMonth()+1}-${now.getDate()} ${now.toLocaleTimeString('en-US',{hour12:false})}`;
        ctx.fillText(info,offset,top);

        $("#recepit_open").trigger("click");
        this.basketList = [];
        this.basket_price.innerHTML = "0";
        this.maplist = this.list.reduce((r,x)=>({...r,[x.id]:x}),{});
        this.basket_list.innerHTML = "";
    }
}

window.onload = ()=>{
    let store = new Store();
}