# Тестовое задание для архитектора

## Задание

Провести рефакторинг существующей системы складского учета и добавить возможность учета нового типа товаров.

## Рассуждения в ходе выполнения задачи

### Ход работы

* Метод `Shop\Shop::getUpdateStrategy` выглядит перегруженным и не расширяемым. Для разных товаров существуют разных алгоритмы обновления качества.
* Если в классе `Shop\Shop` для каждого товара с индивидуальной логикой обновления качества создать отдельный метод, это разгрузит метод `getUpdateStrategy`, однако, если новые товары будут появляться со временем, придется физически менять этот класс. Это приведет к частым обновлениям и раздуванию.
* Следовательно, логично вынести логику обновления качества в `Shop\Item`. Кому как не товару знать как именно у него изменяется качество, в зависимости от времени. Но по условию задачи нельзя менять этот класс.
* Значит нужно делегировать выполнение этой логики на вспомогательный класс и подтягивать объект такого класса в класс `Shop\Shop`.
* В такой реализации просматривается паттерн стратегия, которые я и реализовал. Вынес в отдельное пространство классы-стратегии для разных товаров, связал их общим интерфейсом, а фабрику по подбору требуемой стратегии вынес в отдельный метод `Shop\Shop::getUpdateStrategy`.
* Можно было бы вынести фабрику в отдельный класс, но это было бы избыточной декомпозицией и тогда класс `Shop\Shop` стал бы анемичным (не содержал бы в себе бизнес-логики как таковой).

### Что можно доработать

* У моей реализации есть некоторая проблема, фабрика подбирает стратегию исходя из названия товара.
* Если у нас будут несколько товаров с разными названиями, но с одинаковой, отличной от общей стратегией, придется дублировать класс стратегии (тупо копировать).
* Также, если появится товар с названием Common, с отличной от общей стратегией, ему не получится такую стратегию создать, не изменяя класс `Shop\Shop`.
* Можно избежать этого, если где-то явно указывать какому товару какая стратегия должна быть выбрана.
* Еще можно, совсем экзотично подойти к решению этой проблемы. Можно создавать карту "name" => "stratigy" динамично, на основании данных из каждой конкретной стратегии. Это можно сделать либо через обязательное свойство стратегии (если оно есть и является массивом получить список все товаров которым она соответствует), либо через метод интерфейса "getActualItemNames".
* Но, мне кажется, что это все не очевидные решения и в них очень легко запутаться.

### Лучший вариант

* Вынести логику обновления качества в Item (что запрещено по условию)
* В классе Item создать дополнительное свойство "itemGroup" иди "itemType" (скоропортящиеся, легендартные, выдержанные и т.д.). И вот уже на основе этого свойства динамически подбирать стратегию. Это решит все проблемы и в целом сделает архитектуру более гибкой и расширяемой.
