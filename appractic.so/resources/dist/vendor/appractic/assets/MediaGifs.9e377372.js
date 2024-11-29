import{r as g,h as F,x as Y,a8 as U,H as re,y as A,z as ie,o as s,c as v,F as T,e as X,g as E,d as N,t as q,b as y,n as P,k as M,I as ce,f as w,U as j,ab as z,a as m,ac as ue,u as o,w as f,_ as Z,M as ee,l as te}from"./app.c44491d3.js";import{_ as L,a as se}from"./NoResult.a74ee445.js";import{a as de,_ as le}from"./SearchInput.60b8fe54.js";import{l as K,k as fe}from"./helpers.20120be5.js";import{_ as ae}from"./Alert.e4b3665d.js";import{_ as ne}from"./PrimaryButton.b73070c0.js";import{u as me}from"./useNotifications.07ccb338.js";const W=(l="mixpost.media.fetchUploads",r={})=>{const{notify:a}=me(),c=g("uploads"),x=F(()=>({uploads:"Upload",stock:"Stock Photos",gifs:"GIFs"})),u=g(!1),b=g(!1),$=g(!1),_=g(1),d=g([]),i=g(null),h=g(""),n=g([]),S=p=>{const e=n.value.findIndex(t=>t.id===p.id);e<0&&!p.hasOwnProperty("error")&&n.value.push(p),e>=0&&n.value.splice(e,1)},C=()=>{n.value=[]},k=p=>n.value.findIndex(t=>t.id===p.id)!==-1,I=(p=!0)=>{!_.value||(U.start(),axios.get(route(l,r),{params:{page:_.value,keyword:h.value}}).then(function(e){const t=e.data.links.next;t&&(_.value=e.data.links.next.split("?page=")[1]),t||(_.value=0),p||(d.value=e.data.data),p&&(d.value=[...d.value,...e.data.data])}).catch(()=>{a("error","Error retrieving media. Try again!")}).finally(()=>{U.done(),u.value=!0}))},V=(p,e)=>{b.value=!0,U.start(),axios.post(route("mixpost.media.download",r),{items:p,from:c.value}).then(t=>{e(t)}).catch(()=>{a("error","Error downloading media. Try again!")}).finally(()=>{b.value=!1,U.done(),U.remove()})},G=p=>{d.value=d.value.filter(e=>!p.includes(e.id))},O=(p,e)=>{$.value=!0,U.start(),axios.delete(route("mixpost.media.delete",r),{data:{items:p}}).then(()=>{e()}).catch(()=>{a("error","Error deleting media. Try again!")}).finally(()=>{$.value=!1,U.done(),U.remove()})},R=()=>{const p=new IntersectionObserver(e=>{e[0].isIntersecting&&I()});re(()=>{p.observe(i.value)})};return Y(h,K.exports.debounce(()=>{_.value=1,I(!1)},300)),{activeTab:c,tabs:x,isLoaded:u,isDownloading:b,isDeleting:$,keyword:h,page:_,items:d,endlessPagination:i,selected:n,downloadExternal:V,deletePermanently:O,removeItems:G,createObserver:R,toggleSelect:S,deselectAll:C,isSelected:k}};let ve=(l=21)=>crypto.getRandomValues(new Uint8Array(l)).reduce((r,a)=>(a&=63,a<36?r+=a.toString(36):a<62?r+=(a-26).toString(36).toUpperCase():a>62?r+="-":r+="_",r),"");const pe=["data-column"],B={__name:"Masonry",props:{items:{type:Array,required:!0},columns:{type:Number,default:3}},setup(l){const r=l,a=g(null),c=g([]),x=g(!1);A(()=>{d(),window.addEventListener("resize",u)}),ie(()=>{window.removeEventListener("resize",u)});const u=K.exports.debounce(()=>{c.value.length!==b().length&&d()},300),b=()=>{let i=r.columns;fe().width<=768&&(i=2);const h=[];for(let n=0;n<i;n++)h.push({i:n,indexes:[]});return h},$=i=>{const h=i%c.value.length;c.value[h].indexes.push(i)},_=()=>{for(let i=0;i<r.items.length;i++)$(i)},d=()=>{x.value=!1,c.value.splice(0),c.value.push(...b()),x.value=!0,_()};return Y(()=>r.items,()=>{d()}),(i,h)=>(s(),v("div",{class:P(["flex -m-1",{"opacity-0":!x.value}])},[(s(!0),v(T,null,X(c.value,(n,S)=>(s(),v("div",{class:"flex flex-col grow basis-0 px-1",key:S},[(s(!0),v(T,null,X(n.indexes,C=>(s(),v("div",{class:"py-1",key:C,ref_for:!0,ref:`item_${C}`},[E(i.$slots,"default",{item:l.items[C],index:C},()=>[N(q(l.items[C]),1)])]))),128)),y("div",{class:"grow -mt-20 pt-20 min-h-[100px] -z-10",ref_for:!0,ref_key:"bottomRef",ref:a,"data-column":S},null,8,pe)]))),128))],2))}},J={__name:"MediaSelectable",props:{active:{type:Boolean,default:!1}},emits:["click"],setup(l){return(r,a)=>(s(),v("div",{onClick:a[0]||(a[0]=c=>r.$emit("click")),class:"w-full relative cursor-pointer box-border"},[E(r.$slots,"default"),y("div",{class:P(["absolute flex items-center justify-center top-0 right-0 mr-sm mt-sm w-7 h-7 rounded-full border border-white",{"bg-indigo-500":l.active,"bg-black bg-opacity-20":!l.active}])},[l.active?(s(),M(ce,{key:0,class:"text-white"})):w("",!0)],2)]))}},ge=["onDrop"],_e={class:"relative flex flex-col justify-center"},he=y("div",{class:"text-center mb-1"},[N("Drag & drop files here, or "),y("label",{for:"browse",class:"cursor-pointer text-indigo-500 hover:text-indigo-700 active:text-indigo-700 focus:outline-none focus:text-indigo-700 transition-colors ease-in-out duration-200"}," Browse ")],-1),ye={class:"text-sm text-gray-400 text-center"},xe=["accept"],be={key:0,class:"mt-lg"},ke={__name:"UploadMedia",props:{maxSelection:{type:Number,default:1},combinesMimeTypes:{type:String,default:""},selected:{type:Array,default:[]},toggleSelect:{type:Function},isSelected:{type:Function},columns:{type:Number,default:3}},emits:["mediaSelect"],setup(l,{emit:r}){const a=l,c=j().props.mixpost.mime_types,x=g(null),u=g(!1),b=e=>{if(d.value)return;u.value=!1;const t=_(e.dataTransfer.files);t.length&&O(t)},$=e=>{const t=_(e.target.files);t.length&&(x.value.value=null,O(t))},_=e=>Array.from(e).filter(t=>c.includes(t.type)),d=g(!1),i=g([]),h=g([]),n=g({});Y(n,()=>{S(),d.value=Object.keys(n.value).length>0});const S=()=>{n.value.handler&&n.value.handler()},C=e=>{i.value.push(e),Object.keys(n.value).length===0&&k()},k=e=>{Object.keys(n.value).length>0&&(G(n.value,e),a.toggleSelect&&a.toggleSelect(e)),i.value.length>0?(I(i.value[0]),V()):I({})},I=e=>{n.value=e},V=()=>{i.value.shift()},G=(e,t)=>{h.value.push(Object.assign(e,{media:t}))},O=e=>{e.forEach(t=>{C({id:ve(),handler:async()=>{await R(t).then(D=>{k(D)}).catch(D=>{k({name:t.name,error:D.response.data.message})})}})})},R=e=>{const t=new FormData;return t.append("file",e),new Promise((D,Q)=>{axios.post(route("mixpost.media.upload"),t).then(function(H){D(H.data)}).catch(function(H){Q(H)})})},p=F(()=>h.value.filter(()=>!0).reverse());return g([]),(e,t)=>(s(),v(T,null,[y("div",{onDragenter:t[2]||(t[2]=z(D=>u.value=!d.value,["prevent"])),onDrop:z(b,["prevent"]),onDragover:t[3]||(t[3]=z(()=>{},["prevent"])),class:P([{"border-gray-700 bg-white":!u.value,"border-cyan-500 bg-cyan-50":u.value},"relative w-full flex items-center justify-center rounded-lg p-10 border-2 border-dashed transition-colors ease-in-out duration-200"])},[y("div",_e,[u.value?(s(),v("div",{key:0,onDragleave:t[0]||(t[0]=z(D=>u.value=!1,["prevent"])),onDragover:t[1]||(t[1]=z(()=>{},["prevent"])),class:"w-full h-full absolute"},null,32)):w("",!0),m(ue,{class:P([{"text-stone-700":!u.value,"text-cyan-500":u.value},"!w-16 !h-16 mx-auto mb-xs transition-colors ease-in-out duration-200"])},null,8,["class"]),he,y("div",ye,q(o(c).join(", ")),1)]),d.value?(s(),M(de,{key:0,size:"xl",class:"rounded-lg"})):w("",!0)],42,ge),y("input",{ref_key:"input",ref:x,id:"browse",type:"file",accept:o(c).join(","),multiple:"multiple",class:"hidden",onChange:$},null,40,xe),p.value.length?(s(),v("div",be,[m(B,{items:p.value,columns:l.columns},{default:f(({item:D})=>[m(J,{active:l.isSelected(D.media),onClick:Q=>l.toggleSelect(D.media)},{default:f(()=>[m(L,{media:D.media},null,8,["media"])]),_:2},1032,["active","onClick"])]),_:1},8,["items","columns"])])):w("",!0)],64))}},we={},$e={class:"w-full text-lg"};function Se(l,r){return s(),v("div",$e,[E(l.$slots,"default")])}const Ce=Z(we,[["render",Se]]),Ge={__name:"MediaUploads",props:{columns:{type:Number,default:3}},setup(l,{expose:r}){const{page:a,items:c,endlessPagination:x,selected:u,toggleSelect:b,deselectAll:$,removeItems:_,isSelected:d,createObserver:i}=W();return A(()=>{i()}),r({selected:u,deselectAll:$,removeItems:_}),(h,n)=>(s(),v(T,null,[m(ke,{"max-selection":4,"combines-mime-types":"",selected:o(u),toggleSelect:o(b),isSelected:o(d),columns:l.columns},null,8,["selected","toggleSelect","isSelected","columns"]),y("div",{class:P({"mt-lg":o(c).length})},[o(c).length?(s(),v(T,{key:0},[m(Ce,{class:"mb-4"},{default:f(()=>[N("Library")]),_:1}),m(B,{items:o(c),columns:l.columns},{default:f(({item:S})=>[S?(s(),M(J,{key:0,active:o(d)(S),onClick:C=>o(b)(S)},{default:f(()=>[m(L,{media:S},null,8,["media"])]),_:2},1032,["active","onClick"])):w("",!0)]),_:1},8,["items","columns"])],64)):w("",!0),y("div",{ref_key:"endlessPagination",ref:x,class:"-z-10 w-full"},null,512)],2)],64))}},Ie={},Ne={class:"absolute z-10 bottom-0 mb-xs left-0 ml-xs hidden group-hover:block shadow-mix"},De={class:"bg-white shadow-mix py-xs px-sm text-left rounded-md"};function Te(l,r){return s(),v("div",Ne,[y("div",De,[E(l.$slots,"default")])])}const oe=Z(Ie,[["render",Te]]),Ue={key:0},Me={key:0,class:"mt-lg"},ze=["href"],Fe=["href"],Re={__name:"MediaStock",props:{columns:{type:Number,default:3}},setup(l,{expose:r}){const a=F(()=>K.exports.snakeCase(j().props.app.name)),c=F(()=>j().props.is_configured_service.unsplash),{isLoaded:x,keyword:u,page:b,items:$,endlessPagination:_,selected:d,toggleSelect:i,deselectAll:h,isSelected:n,createObserver:S}=W("mixpost.media.fetchStock");return A(()=>{c.value&&S()}),r({selected:d,deselectAll:h}),(C,k)=>(s(),v(T,null,[c.value?(s(),v("div",Ue,[m(le,{modelValue:o(u),"onUpdate:modelValue":k[0]||(k[0]=I=>ee(u)?u.value=I:null),placeholder:"Search Unsplash"},null,8,["modelValue"]),o($).length?(s(),v("div",Me,[m(B,{items:o($),columns:l.columns},{default:f(({item:I})=>[I?(s(),M(J,{key:0,active:o(n)(I),onClick:V=>o(i)(I)},{default:f(()=>[m(L,{media:I,class:"group"},{default:f(()=>[m(oe,null,{default:f(()=>[y("div",null,[N("Image from "),y("a",{href:`https://unsplash.com/?utm_source=${a.value}&utm_medium=referral`,target:"_blank",class:"link"},"Unsplash",8,ze)]),y("div",null,[N("By "),y("a",{href:`${I.credit_url}?utm_source=${a.value}&utm_medium=referral`,target:"_blank",class:"link"},q(I.name),9,Fe)])]),_:2},1024)]),_:2},1032,["media"])]),_:2},1032,["active","onClick"])):w("",!0)]),_:1},8,["items","columns"])])):w("",!0),o(x)&&!o($).length?(s(),M(se,{key:1,class:"mt-lg"},{default:f(()=>[N("No images found.")]),_:1})):w("",!0),y("div",{ref_key:"endlessPagination",ref:_,class:"-z-10 w-full"},null,512)])):w("",!0),c.value?w("",!0):(s(),v(T,{key:1},[m(ae,{variant:"warning",closeable:!1},{default:f(()=>[N(" You have not configured Unsplash service. ")]),_:1}),m(o(te),{href:C.route("mixpost.services.index"),class:"block mt-md"},{default:f(()=>[m(ne,null,{default:f(()=>[N("Click to configure")]),_:1})]),_:1},8,["href"])],64))],64))}},Pe={key:0},Ve={key:0,class:"mt-lg"},He={__name:"MediaGifs",props:{columns:{type:Number,default:3}},setup(l,{expose:r}){const a=F(()=>j().props.is_configured_service.tenor),{isLoaded:c,keyword:x,page:u,items:b,endlessPagination:$,selected:_,toggleSelect:d,deselectAll:i,isSelected:h,createObserver:n}=W("mixpost.media.fetchGifs");return A(()=>{a.value&&n()}),r({selected:_,deselectAll:i}),(S,C)=>(s(),v(T,null,[a.value?(s(),v("div",Pe,[m(le,{modelValue:o(x),"onUpdate:modelValue":C[0]||(C[0]=k=>ee(x)?x.value=k:null),placeholder:"Search Tenor GIFs"},null,8,["modelValue"]),o(b).length?(s(),v("div",Ve,[m(B,{items:o(b),columns:l.columns},{default:f(({item:k})=>[k?(s(),M(J,{key:0,active:o(h)(k),onClick:I=>o(d)(k)},{default:f(()=>[(s(),M(L,{media:k,key:k.id,class:"group"},{default:f(()=>[m(oe,null,{default:f(()=>[N(" GIF from Tenor ")]),_:1})]),_:2},1032,["media"]))]),_:2},1032,["active","onClick"])):w("",!0)]),_:1},8,["items","columns"])])):w("",!0),o(c)&&!o(b).length?(s(),M(se,{key:1,class:"mt-lg"},{default:f(()=>[N("No GIFs found.")]),_:1})):w("",!0),y("div",{ref_key:"endlessPagination",ref:$,class:"-z-10 w-full"},null,512)])):w("",!0),a.value?w("",!0):(s(),v(T,{key:1},[m(ae,{variant:"warning",closeable:!1},{default:f(()=>[N(" You have not configured Tenor service. ")]),_:1}),m(o(te),{href:S.route("mixpost.services.index"),class:"block mt-md"},{default:f(()=>[m(ne,null,{default:f(()=>[N("Click to configure")]),_:1})]),_:1},8,["href"])],64))],64))}};export{Ge as _,Re as a,He as b,W as u};
