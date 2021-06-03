<template>
	<app-layout>
		<div class="flex flex-col items-center flat card lg lg:px-16">
			<div class="tabs flex mb-8">
				<c-btn
					class="m-2"
					:outlined="$page.component !== 'TermsAndConditions'"
					navigate-to="/terms-and-conditions"
				>{{ trans.get('legal.terms_and_conditions') }}</c-btn>
				<c-btn
					class="m-2"
					:outlined="$page.component !== 'PrivacyPolicy'"
					navigate-to="/privacy-policy"
				>{{ trans.get('legal.privacy_policy') }}</c-btn>
				<c-btn
					class="m-2"
					:outlined="$page.component !== 'CookiePolicy'"
					navigate-to="/cookie-policy"
				>{{ trans.get('legal.cookie_policy') }}</c-btn>
			</div>
			
			<div class="card">
				<h1 class="title text-2xl font-bold mb-4">{{ trans.get('legal.terms_and_conditions') }}</h1>
				<p>Általános Szerződési Feltételek
nyelvtanulóknak
I.
ÁLTALÁNOS RENDELKEZÉSEK
I. 1. A consteach.com a CONSTEACH Bt. által üzemeltetett internetes felület, amelyen keresztül a társaság online nyelvóráknak az óraadók és a nyelvórákat igénybevevők közötti közvetítését végzi. A társaság az internetes felületen a közvetítői tevékenység igénybevételével megrendelt nyelvórák megtartását, valamint a nyelvórák minőségét folyamatosan ellenőrzi, és a közvetítői szolgáltatást igénybe vevők részére internetes ügyfélszolgálatot biztosít. 
I. 2. A CONSTEACH Bt. honlapján keresztül a megrendelni kívánt termék kiválasztásával és a termék díjának elektronikus úton történő megfizetésével vegyes típusú szerződés jön létre a termék megrendelője és a CONSTEACH Bt. között. A vegyes szerződésben a CONSTEACH Bt. közvetítői tevékenységre, online felület biztosítására és jelen szabályzat III. 2. pontjában foglalt egyéb szolgáltatásokra, valamint járulékos letéti szolgáltatásra, a termék megrendelője szolgáltatási díj fizetésére vállal kötelezettséget a III. fejezetben foglaltak szerint.
I. 3. A CONSTEACH Bt. nem végez nyelvoktatási tevékenységet. A honlapon megrendelhető nyelvórákat a CONSTEACH Bt. online felületére regisztrált nyelvtanárok tartják a jelen szabályzat V. fejezetében foglaltak szerint.
I. 4. Értelmező rendelkezések:
Próbaóra: a jelen szabályzat IV. fejezetében szabályozott ingyenes próbaóra, amelyet az érdeklődők a Consteach Bt. szolgáltatásainak megrendelése nélkül is igénybe vehetnek.
II.
ÁLTALÁNOS SZERZŐDÉSI FELTÉTELEK ELFOGADÁSA
II. 1. A Megrendelő a consteach.com weboldalon történő regisztrációt követően, a regisztráció menetét követve, a regisztráció során általa megadott adatok jóváhagyására felkínált oldalon, a „Regisztráció” gomb megnyomásával fogadja el jelen Általános Szerződési Feltételeket.
II. 2. A Megrendelő által kiválasztott termék megrendelésekor, a „Fizetés” gomb megnyomásával az I. 2. pontban meghatározott, írásbelinek nem minősülő szerződés jön létre a Megrendelő és a Szolgáltató között.
II. 3. A Megrendelő jelen Általános Szerződési Feltételek elfogadásával a Szolgáltatónál történő fizetést biztosító Stripe általános szerződési feltételeit is elfogadja. A Stripe általános szerződési feltételei az alábbi linken ismerhetők meg: Privacy Policy - Hungary | Stripe | Hungary


III.
A SZERZŐDÉS A MEGRENDELŐ ÉS A SZOLGÁLTATÓ KÖZÖTT

III. 1. A Szerződés létrejötte
III. 1. 1. A Megrendelő a szerződés megkötése előtt nyelvtanárt választ. A nyelvtanár profilján minden esetben feltüntetésre kerül a nyelvtanár díjszabása. A Megrendelő és a Szolgáltató közötti szerződés (a továbbiakban: Szerződés) az egyes nyelvtanárok profilján feltüntetett termékeknek Megrendelő általi kiválasztása és vásárlási adatainak megadása után, a „Fizetés” gomb megnyomásával jön létre.
III. 1. 2. A Szolgáltató a megrendelés megérkezéséről közvetlenül a megrendelés elküldése után elektronikus úton visszaigazolást küld a Megrendelőnek.
III. 1. 3. A létrejött szerződés nem minősül írásbeli szerződésnek, így az iktatott formában nem hozzáférhető. A szerződés létrejöttét a dokumentált és elektronikusan elmentett megrendelés és az erről a Megrendelőnek közvetlenül a megrendelés elküldése után küldött visszaigazoló e-mail igazolja.
III. 1. 4. A Megrendelő fizetéskor megjelenő adatlap kitöltésével adja meg vásárlási adatait, a Szolgáltató ezeknek megfelelően felel a számla kiállításáért. A hibás vagy hamis adatok megadásából eredő károkért minden felelősség a Megrendelőt terheli.
III. 1. 5. A megrendelésre felkínált termékeknek a “Csomag vásárlása” menüpontban feltüntetett ára tartalmazza a megrendelt órák – nyelvtanárnak fizetendő – tandíját és a Szolgáltató által nyújtott, I. 2. pontban meghatározott szolgáltatások után fizetendő szolgáltatási díjat (a továbbiakban: Illeték). A Megrendelőt a termékek árának megfizetését követően további fizetési kötelezettség nem terheli.
III. 2. A szerződés tartalma
III. 2. 1. A III. 1. 1. pont szerinti megrendelés minden esetben egy vagy több, a Megrendelő által választott tanár által tartott nyelvóra igénybevételére irányul.
III. 2. 2. A Szolgáltató a Szerződés létrejöttét követően lehetőséget nyújt arra, hogy a Megrendelő az általa megrendelt termék leírásában feltüntetett számú tanórát a III. 1. 1. pontban foglaltak szerint kiválasztott nyelvtanár profilján lefoglaljon. A Megrendelő a tanóra lefoglalásakor a nyelvtanár profilján közzétett szabad időpontok közül választhat.
III. 2. 3. A Szolgáltató a nyelvtanár és a Megrendelő közötti kapcsolatfelvételt az általa üzemeltetett internetes felületen keresztül teszi lehetővé. A Megrendelő kötelezettséget vállal, hogy az általa választott nyelvtanárral kizárólag a Szolgáltató által üzemeltetett weboldalon keresztül lép kapcsolatba.
III. 2. 4. A Szolgáltató online ügyfélszolgálatot biztosít. Az online ügyfélszolgálat minden nap 0:00-tól 24:00-ig üzemel.
III. 3. A tandíj kezelése
III. 3. 1. A Megrendelő a Szerződés megkötésével egyidejűleg a Szolgáltató Stripe fizetési szolgáltatónál vezetett számlájára utalja a Szolgáltató által közvetítendő nyelvóráknak a ”Csomag vásárlása” menüpontban meghatározott tandíját.
III. 3. 2. A Stripe a Megrendelő által átutalt pénzösszeget a II. 3. pontban megjelölt általános szerződési feltételekben foglaltak szerint őrzi.
III. 3. 3. A Szolgáltató gondoskodik arról, hogy a Megrendelő részére közvetített és megtartott nyelvórák tandíját a Stripe az óraadó nyelvtanár fizetési szolgáltatónál vezetett alszámlájára átvezesse.
III. 3. 4. Az tanóra megtartását követően óraadó nyelvtanároknak lehetőségük van a Szolgáltató által közvetített nyelvórák tandíját az internetes felületen Stripe alszámlájukra átvezettetni. 
III. 3. 5. A Megrendelő köteles az általa kiválasztott termékben meghatározott számú nyelvórát a megrendeléstől számított 12 hónapos határidőn belül igénybe venni (Lefogyasztási határidő). Amennyiben a Megrendelő a nyelvórákat a lefogyasztási határidőn belül nem veszi igénybe és pénzvisszafizetés iránti igényét a Szolgáltató felé nem jelzi, a Szolgáltató az általa megfizetett tandíjat automatikusan átutalás útján visszafizeti. Az Illetéket a Szolgáltató nem fizeti vissza.
III. 3. 6. A Megrendelő a jelen Általános Szerződési Feltételek elfogadásával hozzájárul ahhoz, hogy a Szolgáltató és a Stripe az általa átutalt pénzösszeget ideiglenesen más Megrendelők által átutalt tandíjakkal együtt, azonos gyűjtőszámlán tárolja.
III. 5. Ellenszolgáltatás
III. 5. 1. A Megrendelő a Szolgáltató által részére nyújtott szolgáltatásokért Illeték fizetésére köteles. Az Illeték összege a „Csomag vásárlása” menüpontban, termékenként kerül meghatározásra.
III. 5. 2. A Megrendelő az Illetéket a szerződés létrejöttével egyidejűleg, a „Fizetés” gomb megnyomását követően a bankkártya adatainak megadásával fizeti meg a Szolgáltató Stripe-nél vezetett fizetési számlájára.
III. 5. 3. A Megrendelő a szerződés létrejöttétől számított 14 napon belül jogosult a szerződéstől elállni, illetve felmondhatja azt. A Megrendelő a szerződéstől való elállását, illetve felmondását a info@consteach.com e-mail címre küldött elektronikus üzenetben közölheti a Szolgáltatóval.
III. 5. 4. A Szolgáltató köteles a Megrendelőnek a III. 5. 3. pontban meghatározott határidőn belül történő elállása, illetve felmondása esetén a részére megfizetett Illeték arányos részének a Megrendelő fizetési számlájára történő visszautalásáról az elállás közlésétől számított 7 munkanapon belül gondoskodni.
III. 5. 5. A Megrendelő III. 5. 3. pont szerinti elállása esetén a Szolgáltató a Megrendelő által már igénybe vett tanórák után megtartott tanóránként a megrendelt termék leírásában feltüntetett összegű Illetékre jogosult.
III. 5. 6. A Megrendelő a III. 5. 3. pontban meghatározott határidő lejártát követően nem állhat el a szerződéstől, és rendes felmondással nem élhet. A Szolgáltatónak ezt követően nem áll módjában az Illetéket visszatéríteni.
IV.
A PRÓBAÓRA
IV. 1. A Szolgáltató minden, a szolgáltatásait igénybe venni szándékozó érdeklődő (a továbbiakban, ebben a fejezetben: Érdeklődő) részére lehetővé teszi, hogy egy általa választott tanártól egy ingyenes próbaórát vegyen igénybe.
IV. 2.  Az Érdeklődő a Próbaórán való részvételre irányuló igényét a nyelvtanár III. 1. 1. pontban meghatározott profilján, a „Csomag vásárlása” menüpontban, a „Próbaóra” elnevezésű termék kiválasztásával jelzi. A termék kiválasztását követően az Érdeklődőnek lehetősége van a nyelvtanár által meghatározott szabad időpontok közül kiválasztani, hogy a Próbaórát mikor kívánja igénybe venni.
IV. 3. A Próbaóra célja az, hogy az Érdeklődő a Próbaórát tartó nyelvtanárral folytatott beszélgetés során megismerkedjen a Szolgáltató által kínált és a nyelvtanár által nyújtott szolgáltatásokkal, és hogy a nyelvtanár tájékozódjon az Érdeklődő nyelvtudásáról, a nyelvtanulással elérni kívánt céljairól és kompetenciájáról. A Próbaórának célja továbbá az is, hogy az Érdeklődő a nyelvtanár segítségével tájékozódjon a Szolgáltató által üzemeltetett internetes felület működéséről és azokról a magatartási szabályokról, amelyeket a Szolgáltató által nyújtott, jelen szabályzatban meghatározott szolgáltatások igénybevétele és a nyelvi tanórákon való részvétel során köteles betartani.
IV. 4. A Próbaóra ingyenes; az Érdeklődő sem a Szolgáltatónak, sem pedig a nyelvtanárnak nem köteles a megtartott Próbaóráért díjat fizetni.
V.
SZERZŐDÉS AZ OKTATÓ ÉS A DIÁK KÖZÖTT
V. 1. Általános rendelkezések
V. 1. 1. A Megrendelő és a részére közvetített nyelvoktató között oktatási szerződés jön létre a jelen fejezetben foglaltak szerint.
V. 1. 2. A Megrendelő (a továbbiakban, kizárólag jelen fejezetben: Megbízó) és a nyelvoktatást végző nyelvtanár (továbbiakban: Oktató) között az első, Megbízó által megrendelt nyelvi tanóra időpontjáról történő megállapodással írásbelinek nem minősülő, határozatlan időre kötött oktatási szerződés jön létre.
V. 2. A szerződés tárgya
V. 2. 1. A Megbízó megbízza az Oktatót, hogy a szerződés megkötésétől határozatlan ideig idegen nyelvi tanórákat tartson számára. A Megbízó a nyelvi órák megtartásáért tandíj fizetésére köteles.
V. 2. 2. Az Oktató a megbízást kizárólag személyesen láthatja el, közvetítő igénybevételére nem jogosult.
V. 3. A tanórák
V. 3. 1. A nyelvi tanórákat az Oktató elektronikus úton – a Szolgáltató által rendelkezésére bocsátott internetes felületbe integrált online classroom szolgáltatás útján köteles megtartani.
V. 3. 2. A tanórák megtartása során követendő tantervről és a tanórák igénybevételéhez szükséges segédanyagokról a Megbízó és az Oktató az első tanórán állapodnak meg.
V. 3. 3. A tanórák időpontja úgy kerül meghatározásra, hogy a Megbízó az általa megvásárolt termék leírásában feltüntetett számú tanórát az Oktató profilján közzétett szabad időpontok közül kiválaszthat és lefoglalhat.
V. 4. A tandíj
V. 4. 1. A Megbízó a részére nyújtott nyelvoktatásért tandíj fizetésére köteles. A tandíj összege az „Csomag vásárlása” menüpontban található termékleírásban, termékenként kerül meghatározásra.
V. 4. 2. A Megbízó által fizetendő tandíj közvetlenül a tanóra megtartását követően válik esedékessé.
V. 4. 3. A tandíjat az Oktató részére a III. 3. 2. és III. 3. 3. pontban foglaltak szerint a Stripe teljesíti a Megbízó által a fizetési szolgáltató számláján elhelyezett pénzösszeg terhére.
V. 4. 4. A Szolgáltató az oktatók által nyújtott szolgáltatásról - a megtartott tanóráról, mint gazdasági eseményről - számlát nem bocsát ki. Az oktatók az ÁFA-törvényben előírt számla kibocsátási kötelezettségükről saját ügykörükben gondoskodnak.
V. 5. A szerződés felmondása
V. 5. 1. A határozatlan időre kötött oktatási szerződést Megbízó bármikor, azonnali hatállyal felmondhatja. A Szolgáltató kötelezettséget vállal arra, hogy amennyiben a Megbízó a szerződést a megkötésétől számított 12 hónapon belül mondja fel, akkor a Megbízó által megfizetett tandíjat a III. 3. 5. pontban foglaltak szerint visszafizeti a Megbízó részére.</p>
<p>
Általános Szerződési Feltételek
Nyelvoktatóknak
I.
ÁLTALÁNOS RENDELKEZÉSEK
I. 1. A consteach.com a CONSTEACH Bt. (a továbbiakban: Szolgáltató) által üzemeltetett internetes felület, amelyen keresztül a társaság online nyelvóráknak az óraadók és a nyelvórákat igénybevevők közötti közvetítését végzi. A társaság az internetes felületen a közvetítői tevékenység igénybevételével megrendelt nyelvórák megtartását, valamint a nyelvórák minőségét folyamatosan ellenőrzi, és a közvetítői szolgáltatást igénybe vevők részére internetes ügyfélszolgálatot biztosít. 
I. 2. A Szolgáltató az internetes felületre regisztrált – és a regisztrációval jelen általános szerződési feltételeket elfogadó – óraadó (a továbbiakban: Oktató) részére a jelen szabályzat II. fejezetében meghatározott szerződésben foglaltak szerint közvetítői tevékenységet nyújt, és a közvetített nyelvórák megtartásának elősegítésére internetes felületet biztosít.
I. 3. A jelen szabályzatot elfogadó Oktató kötelezettséget vállal arra, hogy az I. számú mellékletben található Etikai Szabályzatban foglalt magatartási szabályokat az általa a részére közvetített tanulóknak tartott nyelvi tanórák megszervezése, megtartása és utólagos dokumentációja, valamint a tanulókkal való nyelvi tanórán kívüli konzultációk során betartja.
I. 4. Értelmező rendelkezések:
Online nyelvoktatási tevékenység: a Szolgáltató közvetítői tevékenysége keretében létrejött oktatási szerződések alapján az Oktató elektronikus hírközlő eszközön keresztül idegen nyelvi tanórákat tart.
II.
ÁLTALÁNOS SZERZŐDÉSI FELTÉTELEK ELFOGADÁSA
II. 1. Az Oktató a consteach.com weboldalon történő regisztrációt követően, a regisztráció menetét követve, a regisztráció során általa megadott adatok jóváhagyására felkínált oldalon, a „Regisztráció” gomb megnyomásával fogadja el jelen Általános Szerződési Feltételeket.
II. 2. Az Oktató regisztrációjakor a „Regisztráció” gomb megnyomásával az I. 2. pontban meghatározott, írásbelinek nem minősülő, határozatlan időre kötött megbízási szerződés jön létre az Oktató és a Szolgáltató között.




III.
SZERZŐDÉS AZ OKTATÓ ÉS A SZOLGÁLTATÓ KÖZÖTT
III. 1. Általános rendelkezések
III. 1. 1. Az Oktató megbízza a Szolgáltatót, hogy olyan tanulókat közvetítsen a részére, akik az általa nyújtott online nyelvoktatási szolgáltatást igénybe veszik. A Szolgáltató az Oktatónak nyújtott közvetítői tevékenységet úgy végzi, hogy az általa üzemeltetett internetes felületre regisztrált tanulók és a jelen szabályzatot a honlapon történő regisztrációval elfogadó oktatók között az I. 1.. pontban meghatározott oktatási szerződések megkötését elősegíti. A közvetítői tevékenység keretében a Szolgáltató lehetőséget teremt a jelen szabályzatot a honlapon történő regisztrációval elfogadó oktatók és az általa üzemeltetett internetes felületre regisztrált tanulók közötti, I. 1. pontban meghatározott, nyelvórák megtartására irányuló oktatási szerződések megkötésére.
III. 1. 2. Az Oktató a Szolgáltató által nyújtott közvetítői tevékenységért nem tartozik ellenszolgáltatással. Jelen szerződés ingyenes szerződésnek minősül.
III. 1. 3. Az Oktató kötelezettséget vállal arra, hogy a jelen szerződésben részére előírt magatartási szabályokat a Szolgáltató tevékenységének igénybevétele során és azt követően betartja.
III. 2. A Szerződés létrejötte
III. 2. 1. Az Oktató és a Szolgáltató közötti szerződés (a továbbiakban: Szerződés) a Szolgáltató által üzemeltetett internetes felületen történő regisztráció befejezésekor, a jelen szabályzat II. 2. pontban meghatározottak szerinti elfogadásával jön létre. 
III. 2. 2. A Szolgáltató a sikeres regisztrációról közvetlenül a regisztráció befejezése után, elektronikus úton visszaigazolást küld az Oktatónak.
III. 2. 3. Az Oktató a honlapon történő regisztráció során adja meg az adatait. Az Oktatónak a regisztráció végén lehetősége van adatait ellenőrizni és módosítani, de ezt a sikeres regisztráció után is bármikor megteheti, a Személyes adatok menüpont alatt. A hibás vagy hamis adatok megadásából eredő károkért minden felelősség – törvény eltérő rendelkezése hiányában – az Oktatót terheli.
III. 3. Versenykorlátozás
III. 3. 1. Az Oktató a részére jelen Szerződés alapján közvetített tanulóknak kizárólag a Szolgáltatón keresztül, a jelen szabályzat III. 6. fejezetében meghatározottak szerint jogosult online nyelvoktatási tevékenységet nyújtani. Az Oktató kötelezettséget vállal arra, hogy nem nyújt a részére közvetített tanulóknak online nyelvoktatási szolgáltatást a Szolgáltató megkerülésével.
III. 3. 2. Az Oktató kötelezettséget vállal arra, hogy jelen szerződés bármely okból történő megszűnése esetén a szerződés megszűnésétől számított 10 munkanapon belül a részére jelen szerződés alapján közvetített tanulókkal kötött, I. fejezetben meghatározott oktatási szerződéseit azonnali hatállyal felmondja, a tanulókat a Szolgáltatóval fennálló jogviszonya megszűnéséről tájékoztatja, és a tanulóknak nyújtott online nyelvoktatási szolgáltatás során készült feljegyzéseit (a tanuló nyelvtanulással elérni kívánt céljairól, a tanórák során átvett tananyagról, szakmailag hasznos észrevételekről és javaslatokról, a tanuló időbeosztásáról, elérhetőségeiről, stb.) a Szolgáltatónak – elektronikus úton – elküldi.
III. 3. 3. Az Oktató kötelezettséget vállal arra, hogy jelen szerződés bármely okból történő megszűnése esetén a szerződés megszűnésétől számított 24 hónapig nem nyújt online nyelvoktatási szolgáltatást a részére jelen szerződés alapján a Szolgáltató által közvetített tanulóknak.
III. 3. 4. Amennyiben az Oktató a III. 3. 1. vagy a III. 3. 2. pontot sértő módon nyújt online nyelvoktatási szolgáltatást a részére közvetített tanulóknak, köteles 200.000,-Ft, azaz kétszázezer forint összegű kötbért 10 munkanapon belül a Szolgáltatónak megfizetni.
III. 4. Próbaóra
III. 4. 1. Az Oktató kötelezettséget vállal arra, hogy minden olyan, a részére jelen szerződés alapján közvetített tanulónak, aki a Szolgáltató által üzemeltetett felületen a rendelkezésére álló próbaórát még nem használta fel, 1 db ingyenes próbaórát tart.
III. 4. 2. A Próbaóra célja az, hogy a tanuló a Próbaórát tartó Oktatóval folytatott beszélgetés során megismerkedjen a Szolgáltató által közvetített és az Oktató által nyújtott szolgáltatásokkal, és hogy az Oktató tájékozódjon a tanuló nyelvtudásáról, a nyelvtanulással elérni kívánt céljairól és kompetenciájáról. A Próbaórának célja továbbá az is, hogy a tanuló a nyelvtanár segítségével tájékozódjon a Szolgáltató által üzemeltetett internetes felület működéséről és azokról a magatartási szabályokról, amelyeket a Szolgáltató által nyújtott szolgáltatások igénybevétele és a nyelvi tanórákon való részvétel során köteles betartani.
III. 5. Fizetés és számlakibocsátás
III. 6. 1. A Szolgáltató az Oktató online nyelvi tanórák megtartásából eredő díjigényével kapcsolatban számlát nem bocsát ki. Az Oktató törvényben előírt számla kibocsátási kötelezettségéről saját ügykörében köteles gondoskodni.
III. 6. 2. Az Oktató részére közvetített tanuló az Oktató által szolgáltatott nyelvi órák tandíját a Szolgáltató Stripe fizetési szolgáltatónál (a továbbiakban: Fizetési Szolgáltató) vezetett számlájára fizeti meg, átutalással.
III. 6. 3. Az Oktató jelen szabályzat elfogadásával a Fizetési Szolgáltató általános szerződési feltételeit is elfogadja. A Fizetési Szolgáltató általános szerződési feltételei az alábbi linken érhetők el: Privacy Policy - Hungary | Stripe | Hungary
III. 6. 4. Az Oktatónak a Szolgáltató által közvetített tanóra megtartását követően lehetőségük van a arra, hogy a tanóra tandíját a Szolgáltató internetes felületén Stripe alszámlájára átvezettesse.
III. 6. 5. Szolgáltató által üzemeltetett weboldalon Oktatóként történő regisztrációnak feltétele az, hogy az Oktató rendelkezzen saját Stripe felhasználóval. Az Oktató a Szolgáltató által üzemeltetett weboldalon kizárólag akkor tud regisztrálni, ha a regisztráció során Stripe azonosítóját megadja.
III. 6. 6. Az Oktatónak a Szolgáltató által rendelkezésére bocsátott internetes felületen lehetősége van arra, hogy az általa tartott nyelvi tanórák tandíját szabadon határozza meg.


</p>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
	components: {AppLayout},
	data() {
		return {
			tab: 0,
			
		};
	},
	mounted() {
		let title = this.trans.get('legal.terms_and_conditions_document_title');
		this.$root.documentTitle(title);
	},
	methods: {
	
	}
}
</script>