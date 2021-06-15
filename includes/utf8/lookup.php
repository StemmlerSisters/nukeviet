<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 22/8/2010, 19:32
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

// @formatter:off
$utf8_lookup = [
    'strtoupper' => [
        'ｚ' => 'Ｚ', 'ｙ' => 'Ｙ', 'ｘ' => 'Ｘ', 'ｗ' => 'Ｗ', 'ｖ' => 'Ｖ', 'ｕ' => 'Ｕ', 'ｔ' => 'Ｔ', 'ｓ' => 'Ｓ', 'ｒ' => 'Ｒ', 'ｑ' => 'Ｑ',
        'ｐ' => 'Ｐ', 'ｏ' => 'Ｏ', 'ｎ' => 'Ｎ', 'ｍ' => 'Ｍ', 'ｌ' => 'Ｌ', 'ｋ' => 'Ｋ', 'ｊ' => 'Ｊ', 'ｉ' => 'Ｉ', 'ｈ' => 'Ｈ', 'ｇ' => 'Ｇ',
        'ｆ' => 'Ｆ', 'ｅ' => 'Ｅ', 'ｄ' => 'Ｄ', 'ｃ' => 'Ｃ', 'ｂ' => 'Ｂ', 'ａ' => 'Ａ', 'ῳ' => 'ῼ', 'ῥ' => 'Ῥ', 'ῡ' => 'Ῡ', 'ῑ' => 'Ῑ',
        'ῐ' => 'Ῐ', 'ῃ' => 'ῌ', 'ι' => 'Ι', 'ᾳ' => 'ᾼ', 'ᾱ' => 'Ᾱ', 'ᾰ' => 'Ᾰ', 'ᾧ' => 'ᾯ', 'ᾦ' => 'ᾮ', 'ᾥ' => 'ᾭ', 'ᾤ' => 'ᾬ',
        'ᾣ' => 'ᾫ', 'ᾢ' => 'ᾪ', 'ᾡ' => 'ᾩ', 'ᾗ' => 'ᾟ', 'ᾖ' => 'ᾞ', 'ᾕ' => 'ᾝ', 'ᾔ' => 'ᾜ', 'ᾓ' => 'ᾛ', 'ᾒ' => 'ᾚ', 'ᾑ' => 'ᾙ',
        'ᾐ' => 'ᾘ', 'ᾇ' => 'ᾏ', 'ᾆ' => 'ᾎ', 'ᾅ' => 'ᾍ', 'ᾄ' => 'ᾌ', 'ᾃ' => 'ᾋ', 'ᾂ' => 'ᾊ', 'ᾁ' => 'ᾉ', 'ᾀ' => 'ᾈ', 'ώ' => 'Ώ',
        'ὼ' => 'Ὼ', 'ύ' => 'Ύ', 'ὺ' => 'Ὺ', 'ό' => 'Ό', 'ὸ' => 'Ὸ', 'ί' => 'Ί', 'ὶ' => 'Ὶ', 'ή' => 'Ή', 'ὴ' => 'Ὴ', 'έ' => 'Έ',
        'ὲ' => 'Ὲ', 'ά' => 'Ά', 'ὰ' => 'Ὰ', 'ὧ' => 'Ὧ', 'ὦ' => 'Ὦ', 'ὥ' => 'Ὥ', 'ὤ' => 'Ὤ', 'ὣ' => 'Ὣ', 'ὢ' => 'Ὢ', 'ὡ' => 'Ὡ',
        'ὗ' => 'Ὗ', 'ὕ' => 'Ὕ', 'ὓ' => 'Ὓ', 'ὑ' => 'Ὑ', 'ὅ' => 'Ὅ', 'ὄ' => 'Ὄ', 'ὃ' => 'Ὃ', 'ὂ' => 'Ὂ', 'ὁ' => 'Ὁ', 'ὀ' => 'Ὀ',
        'ἷ' => 'Ἷ', 'ἶ' => 'Ἶ', 'ἵ' => 'Ἵ', 'ἴ' => 'Ἴ', 'ἳ' => 'Ἳ', 'ἲ' => 'Ἲ', 'ἱ' => 'Ἱ', 'ἰ' => 'Ἰ', 'ἧ' => 'Ἧ', 'ἦ' => 'Ἦ',
        'ἥ' => 'Ἥ', 'ἤ' => 'Ἤ', 'ἣ' => 'Ἣ', 'ἢ' => 'Ἢ', 'ἡ' => 'Ἡ', 'ἕ' => 'Ἕ', 'ἔ' => 'Ἔ', 'ἓ' => 'Ἓ', 'ἒ' => 'Ἒ', 'ἑ' => 'Ἑ',
        'ἐ' => 'Ἐ', 'ἇ' => 'Ἇ', 'ἆ' => 'Ἆ', 'ἅ' => 'Ἅ', 'ἄ' => 'Ἄ', 'ἃ' => 'Ἃ', 'ἂ' => 'Ἂ', 'ἁ' => 'Ἁ', 'ἀ' => 'Ἀ', 'ỹ' => 'Ỹ',
        'ỷ' => 'Ỷ', 'ỵ' => 'Ỵ', 'ỳ' => 'Ỳ', 'ự' => 'Ự', 'ữ' => 'Ữ', 'ử' => 'Ử', 'ừ' => 'Ừ', 'ứ' => 'Ứ', 'ủ' => 'Ủ', 'ụ' => 'Ụ',
        'ợ' => 'Ợ', 'ỡ' => 'Ỡ', 'ở' => 'Ở', 'ờ' => 'Ờ', 'ớ' => 'Ớ', 'ộ' => 'Ộ', 'ỗ' => 'Ỗ', 'ổ' => 'Ổ', 'ồ' => 'Ồ', 'ố' => 'Ố',
        'ỏ' => 'Ỏ', 'ọ' => 'Ọ', 'ị' => 'Ị', 'ỉ' => 'Ỉ', 'ệ' => 'Ệ', 'ễ' => 'Ễ', 'ể' => 'Ể', 'ề' => 'Ề', 'ế' => 'Ế', 'ẽ' => 'Ẽ',
        'ẻ' => 'Ẻ', 'ẹ' => 'Ẹ', 'ặ' => 'Ặ', 'ẵ' => 'Ẵ', 'ẳ' => 'Ẳ', 'ằ' => 'Ằ', 'ắ' => 'Ắ', 'ậ' => 'Ậ', 'ẫ' => 'Ẫ', 'ẩ' => 'Ẩ',
        'ầ' => 'Ầ', 'ấ' => 'Ấ', 'ả' => 'Ả', 'ạ' => 'Ạ', 'ẛ' => 'Ṡ', 'ẕ' => 'Ẕ', 'ẓ' => 'Ẓ', 'ẑ' => 'Ẑ', 'ẏ' => 'Ẏ', 'ẍ' => 'Ẍ',
        'ẋ' => 'Ẋ', 'ẉ' => 'Ẉ', 'ẇ' => 'Ẇ', 'ẅ' => 'Ẅ', 'ẃ' => 'Ẃ', 'ẁ' => 'Ẁ', 'ṿ' => 'Ṿ', 'ṽ' => 'Ṽ', 'ṻ' => 'Ṻ', 'ṹ' => 'Ṹ',
        'ṷ' => 'Ṷ', 'ṵ' => 'Ṵ', 'ṳ' => 'Ṳ', 'ṱ' => 'Ṱ', 'ṯ' => 'Ṯ', 'ṭ' => 'Ṭ', 'ṫ' => 'Ṫ', 'ṩ' => 'Ṩ', 'ṧ' => 'Ṧ', 'ṥ' => 'Ṥ',
        'ṣ' => 'Ṣ', 'ṡ' => 'Ṡ', 'ṟ' => 'Ṟ', 'ṝ' => 'Ṝ', 'ṛ' => 'Ṛ', 'ṙ' => 'Ṙ', 'ṗ' => 'Ṗ', 'ṕ' => 'Ṕ', 'ṓ' => 'Ṓ', 'ṑ' => 'Ṑ',
        'ṏ' => 'Ṏ', 'ṍ' => 'Ṍ', 'ṋ' => 'Ṋ', 'ṉ' => 'Ṉ', 'ṇ' => 'Ṇ', 'ṅ' => 'Ṅ', 'ṃ' => 'Ṃ', 'ṁ' => 'Ṁ', 'ḿ' => 'Ḿ', 'ḽ' => 'Ḽ',
        'ḻ' => 'Ḻ', 'ḹ' => 'Ḹ', 'ḷ' => 'Ḷ', 'ḵ' => 'Ḵ', 'ḳ' => 'Ḳ', 'ḱ' => 'Ḱ', 'ḯ' => 'Ḯ', 'ḭ' => 'Ḭ', 'ḫ' => 'Ḫ', 'ḩ' => 'Ḩ',
        'ḧ' => 'Ḧ', 'ḥ' => 'Ḥ', 'ḣ' => 'Ḣ', 'ḡ' => 'Ḡ', 'ḟ' => 'Ḟ', 'ḝ' => 'Ḝ', 'ḛ' => 'Ḛ', 'ḙ' => 'Ḙ', 'ḗ' => 'Ḗ', 'ḕ' => 'Ḕ',
        'ḓ' => 'Ḓ', 'ḑ' => 'Ḑ', 'ḏ' => 'Ḏ', 'ḍ' => 'Ḍ', 'ḋ' => 'Ḋ', 'ḉ' => 'Ḉ', 'ḇ' => 'Ḇ', 'ḅ' => 'Ḅ', 'ḃ' => 'Ḃ', 'ḁ' => 'Ḁ',
        'ֆ' => 'Ֆ', 'օ' => 'Օ', 'ք' => 'Ք', 'փ' => 'Փ', 'ւ' => 'Ւ', 'ց' => 'Ց', 'ր' => 'Ր', 'տ' => 'Տ', 'վ' => 'Վ', 'ս' => 'Ս',
        'ռ' => 'Ռ', 'ջ' => 'Ջ', 'պ' => 'Պ', 'չ' => 'Չ', 'ո' => 'Ո', 'շ' => 'Շ', 'ն' => 'Ն', 'յ' => 'Յ', 'մ' => 'Մ', 'ճ' => 'Ճ',
        'ղ' => 'Ղ', 'ձ' => 'Ձ', 'հ' => 'Հ', 'կ' => 'Կ', 'ծ' => 'Ծ', 'խ' => 'Խ', 'լ' => 'Լ', 'ի' => 'Ի', 'ժ' => 'Ժ', 'թ' => 'Թ',
        'ը' => 'Ը', 'է' => 'Է', 'զ' => 'Զ', 'ե' => 'Ե', 'դ' => 'Դ', 'գ' => 'Գ', 'բ' => 'Բ', 'ա' => 'Ա', 'ԏ' => 'Ԏ', 'ԍ' => 'Ԍ',
        'ԋ' => 'Ԋ', 'ԉ' => 'Ԉ', 'ԇ' => 'Ԇ', 'ԅ' => 'Ԅ', 'ԃ' => 'Ԃ', 'ԁ' => 'Ԁ', 'ӹ' => 'Ӹ', 'ӵ' => 'Ӵ', 'ӳ' => 'Ӳ', 'ӱ' => 'Ӱ',
        'ӯ' => 'Ӯ', 'ӭ' => 'Ӭ', 'ӫ' => 'Ӫ', 'ө' => 'Ө', 'ӧ' => 'Ӧ', 'ӥ' => 'Ӥ', 'ӣ' => 'Ӣ', 'ӡ' => 'Ӡ', 'ӟ' => 'Ӟ', 'ӝ' => 'Ӝ',
        'ӛ' => 'Ӛ', 'ә' => 'Ә', 'ӗ' => 'Ӗ', 'ӕ' => 'Ӕ', 'ӓ' => 'Ӓ', 'ӑ' => 'Ӑ', 'ӎ' => 'Ӎ', 'ӌ' => 'Ӌ', 'ӊ' => 'Ӊ', 'ӈ' => 'Ӈ',
        'ӆ' => 'Ӆ', 'ӄ' => 'Ӄ', 'ӂ' => 'Ӂ', 'ҿ' => 'Ҿ', 'ҽ' => 'Ҽ', 'һ' => 'Һ', 'ҹ' => 'Ҹ', 'ҷ' => 'Ҷ', 'ҵ' => 'Ҵ', 'ҳ' => 'Ҳ',
        'ұ' => 'Ұ', 'ү' => 'Ү', 'ҭ' => 'Ҭ', 'ҫ' => 'Ҫ', 'ҩ' => 'Ҩ', 'ҧ' => 'Ҧ', 'ҥ' => 'Ҥ', 'ң' => 'Ң', 'ҡ' => 'Ҡ', 'ҟ' => 'Ҟ',
        'ҝ' => 'Ҝ', 'қ' => 'Қ', 'ҙ' => 'Ҙ', 'җ' => 'Җ', 'ҕ' => 'Ҕ', 'ғ' => 'Ғ', 'ґ' => 'Ґ', 'ҏ' => 'Ҏ', 'ҍ' => 'Ҍ', 'ҋ' => 'Ҋ',
        'ҁ' => 'Ҁ', 'ѿ' => 'Ѿ', 'ѽ' => 'Ѽ', 'ѻ' => 'Ѻ', 'ѹ' => 'Ѹ', 'ѷ' => 'Ѷ', 'ѵ' => 'Ѵ', 'ѳ' => 'Ѳ', 'ѱ' => 'Ѱ', 'ѯ' => 'Ѯ',
        'ѭ' => 'Ѭ', 'ѫ' => 'Ѫ', 'ѩ' => 'Ѩ', 'ѧ' => 'Ѧ', 'ѥ' => 'Ѥ', 'ѣ' => 'Ѣ', 'ѡ' => 'Ѡ', 'џ' => 'Џ', 'ў' => 'Ў', 'ѝ' => 'Ѝ',
        'ќ' => 'Ќ', 'ћ' => 'Ћ', 'њ' => 'Њ', 'љ' => 'Љ', 'ј' => 'Ј', 'ї' => 'Ї', 'і' => 'І', 'ѕ' => 'Ѕ', 'є' => 'Є', 'ѓ' => 'Ѓ',
        'ђ' => 'Ђ', 'ё' => 'Ё', 'ѐ' => 'Ѐ', 'я' => 'Я', 'ю' => 'Ю', 'э' => 'Э', 'ь' => 'Ь', 'ы' => 'Ы', 'ъ' => 'Ъ', 'щ' => 'Щ',
        'ш' => 'Ш', 'ч' => 'Ч', 'ц' => 'Ц', 'х' => 'Х', 'ф' => 'Ф', 'у' => 'У', 'т' => 'Т', 'с' => 'С', 'р' => 'Р', 'п' => 'П',
        'о' => 'О', 'н' => 'Н', 'м' => 'М', 'л' => 'Л', 'к' => 'К', 'й' => 'Й', 'и' => 'И', 'з' => 'З', 'ж' => 'Ж', 'е' => 'Е',
        'д' => 'Д', 'г' => 'Г', 'в' => 'В', 'б' => 'Б', 'а' => 'А', 'ϵ' => 'Ε', 'ϲ' => 'Σ', 'ϱ' => 'Ρ', 'ϰ' => 'Κ', 'ϯ' => 'Ϯ',
        'ϭ' => 'Ϭ', 'ϫ' => 'Ϫ', 'ϩ' => 'Ϩ', 'ϧ' => 'Ϧ', 'ϥ' => 'Ϥ', 'ϣ' => 'Ϣ', 'ϡ' => 'Ϡ', 'ϟ' => 'Ϟ', 'ϝ' => 'Ϝ', 'ϛ' => 'Ϛ',
        'ϙ' => 'Ϙ', 'ϖ' => 'Π', 'ϕ' => 'Φ', 'ϑ' => 'Θ', 'ϐ' => 'Β', 'ώ' => 'Ώ', 'ύ' => 'Ύ', 'ό' => 'Ό', 'ϋ' => 'Ϋ', 'ϊ' => 'Ϊ',
        'ω' => 'Ω', 'ψ' => 'Ψ', 'χ' => 'Χ', 'φ' => 'Φ', 'υ' => 'Υ', 'τ' => 'Τ', 'σ' => 'Σ', 'ς' => 'Σ', 'ρ' => 'Ρ', 'π' => 'Π',
        'ο' => 'Ο', 'ξ' => 'Ξ', 'ν' => 'Ν', 'μ' => 'Μ', 'λ' => 'Λ', 'κ' => 'Κ', 'ι' => 'Ι', 'θ' => 'Θ', 'η' => 'Η', 'ζ' => 'Ζ',
        'ε' => 'Ε', 'δ' => 'Δ', 'γ' => 'Γ', 'β' => 'Β', 'α' => 'Α', 'ί' => 'Ί', 'ή' => 'Ή', 'έ' => 'Έ', 'ά' => 'Ά', 'ʒ' => 'Ʒ',
        'ʋ' => 'Ʋ', 'ʊ' => 'Ʊ', 'ʈ' => 'Ʈ', 'ʃ' => 'Ʃ', 'ʀ' => 'Ʀ', 'ɵ' => 'Ɵ', 'ɲ' => 'Ɲ', 'ɯ' => 'Ɯ', 'ɩ' => 'Ɩ', 'ɨ' => 'Ɨ',
        'ɣ' => 'Ɣ', 'ɛ' => 'Ɛ', 'ə' => 'Ə', 'ɗ' => 'Ɗ', 'ɖ' => 'Ɖ', 'ɔ' => 'Ɔ', 'ɓ' => 'Ɓ', 'ȳ' => 'Ȳ', 'ȱ' => 'Ȱ', 'ȯ' => 'Ȯ',
        'ȭ' => 'Ȭ', 'ȫ' => 'Ȫ', 'ȩ' => 'Ȩ', 'ȧ' => 'Ȧ', 'ȥ' => 'Ȥ', 'ȣ' => 'Ȣ', 'ȟ' => 'Ȟ', 'ȝ' => 'Ȝ', 'ț' => 'Ț', 'ș' => 'Ș',
        'ȗ' => 'Ȗ', 'ȕ' => 'Ȕ', 'ȓ' => 'Ȓ', 'ȑ' => 'Ȑ', 'ȏ' => 'Ȏ', 'ȍ' => 'Ȍ', 'ȋ' => 'Ȋ', 'ȉ' => 'Ȉ', 'ȇ' => 'Ȇ', 'ȅ' => 'Ȅ',
        'ȃ' => 'Ȃ', 'ȁ' => 'Ȁ', 'ǿ' => 'Ǿ', 'ǽ' => 'Ǽ', 'ǻ' => 'Ǻ', 'ǹ' => 'Ǹ', 'ǵ' => 'Ǵ', 'ǳ' => 'ǲ', 'ǯ' => 'Ǯ', 'ǭ' => 'Ǭ',
        'ǫ' => 'Ǫ', 'ǩ' => 'Ǩ', 'ǧ' => 'Ǧ', 'ǥ' => 'Ǥ', 'ǣ' => 'Ǣ', 'ǡ' => 'Ǡ', 'ǟ' => 'Ǟ', 'ǝ' => 'Ǝ', 'ǜ' => 'Ǜ', 'ǚ' => 'Ǚ',
        'ǘ' => 'Ǘ', 'ǖ' => 'Ǖ', 'ǔ' => 'Ǔ', 'ǒ' => 'Ǒ', 'ǐ' => 'Ǐ', 'ǎ' => 'Ǎ', 'ǌ' => 'ǋ', 'ǉ' => 'ǈ', 'ǆ' => 'ǅ', 'ƿ' => 'Ƿ',
        'ƽ' => 'Ƽ', 'ƹ' => 'Ƹ', 'ƶ' => 'Ƶ', 'ƴ' => 'Ƴ', 'ư' => 'Ư', 'ƭ' => 'Ƭ', 'ƨ' => 'Ƨ', 'ƥ' => 'Ƥ', 'ƣ' => 'Ƣ', 'ơ' => 'Ơ',
        'ƞ' => 'Ƞ', 'ƙ' => 'Ƙ', 'ƕ' => 'Ƕ', 'ƒ' => 'Ƒ', 'ƌ' => 'Ƌ', 'ƈ' => 'Ƈ', 'ƅ' => 'Ƅ', 'ƃ' => 'Ƃ', 'ſ' => 'S', 'ž' => 'Ž',
        'ż' => 'Ż', 'ź' => 'Ź', 'ŷ' => 'Ŷ', 'ŵ' => 'Ŵ', 'ų' => 'Ų', 'ű' => 'Ű', 'ů' => 'Ů', 'ŭ' => 'Ŭ', 'ū' => 'Ū', 'ũ' => 'Ũ',
        'ŧ' => 'Ŧ', 'ť' => 'Ť', 'ţ' => 'Ţ', 'š' => 'Š', 'ş' => 'Ş', 'ŝ' => 'Ŝ', 'ś' => 'Ś', 'ř' => 'Ř', 'ŗ' => 'Ŗ', 'ŕ' => 'Ŕ',
        'œ' => 'Œ', 'ő' => 'Ő', 'ŏ' => 'Ŏ', 'ō' => 'Ō', 'ŋ' => 'Ŋ', 'ň' => 'Ň', 'ņ' => 'Ņ', 'ń' => 'Ń', 'ł' => 'Ł', 'ŀ' => 'Ŀ',
        'ľ' => 'Ľ', 'ļ' => 'Ļ', 'ĺ' => 'Ĺ', 'ķ' => 'Ķ', 'ĵ' => 'Ĵ', 'ĳ' => 'Ĳ', 'ı' => 'I', 'į' => 'Į', 'ĭ' => 'Ĭ', 'ī' => 'Ī',
        'ĩ' => 'Ĩ', 'ħ' => 'Ħ', 'ĥ' => 'Ĥ', 'ģ' => 'Ģ', 'ġ' => 'Ġ', 'ğ' => 'Ğ', 'ĝ' => 'Ĝ', 'ě' => 'Ě', 'ę' => 'Ę', 'ė' => 'Ė',
        'ĕ' => 'Ĕ', 'ē' => 'Ē', 'đ' => 'Đ', 'ď' => 'Ď', 'č' => 'Č', 'ċ' => 'Ċ', 'ĉ' => 'Ĉ', 'ć' => 'Ć', 'ą' => 'Ą', 'ă' => 'Ă',
        'ā' => 'Ā', 'ÿ' => 'Ÿ', 'þ' => 'Þ', 'ý' => 'Ý', 'ü' => 'Ü', 'û' => 'Û', 'ú' => 'Ú', 'ù' => 'Ù', 'ø' => 'Ø', 'ö' => 'Ö',
        'õ' => 'Õ', 'ô' => 'Ô', 'ó' => 'Ó', 'ò' => 'Ò', 'ñ' => 'Ñ', 'ð' => 'Ð', 'ï' => 'Ï', 'î' => 'Î', 'í' => 'Í', 'ì' => 'Ì',
        'ë' => 'Ë', 'ê' => 'Ê', 'é' => 'É', 'è' => 'È', 'ç' => 'Ç', 'æ' => 'Æ', 'å' => 'Å', 'ä' => 'Ä', 'ã' => 'Ã', 'â' => 'Â',
        'á' => 'Á', 'à' => 'À', 'µ' => 'Μ', 'z' => 'Z', 'y' => 'Y', 'x' => 'X', 'w' => 'W', 'v' => 'V', 'u' => 'U', 't' => 'T',
        's' => 'S', 'r' => 'R', 'q' => 'Q', 'p' => 'P', 'o' => 'O', 'n' => 'N', 'm' => 'M', 'l' => 'L', 'k' => 'K', 'j' => 'J',
        'i' => 'I', 'h' => 'H', 'g' => 'G', 'f' => 'F', 'e' => 'E', 'd' => 'D', 'c' => 'C', 'b' => 'B', 'a' => 'A'
    ],
    'strtolower' => [
        'Ｚ' => 'ｚ', 'Ｙ' => 'ｙ', 'Ｘ' => 'ｘ', 'Ｗ' => 'ｗ', 'Ｖ' => 'ｖ', 'Ｕ' => 'ｕ', 'Ｔ' => 'ｔ', 'Ｓ' => 'ｓ', 'Ｒ' => 'ｒ', 'Ｑ' => 'ｑ',
        'Ｐ' => 'ｐ', 'Ｏ' => 'ｏ', 'Ｎ' => 'ｎ', 'Ｍ' => 'ｍ', 'Ｌ' => 'ｌ', 'Ｋ' => 'ｋ', 'Ｊ' => 'ｊ', 'Ｉ' => 'ｉ', 'Ｈ' => 'ｈ', 'Ｇ' => 'ｇ',
        'Ｆ' => 'ｆ', 'Ｅ' => 'ｅ', 'Ｄ' => 'ｄ', 'Ｃ' => 'ｃ', 'Ｂ' => 'ｂ', 'Ａ' => 'ａ', 'ῼ' => 'ῳ', 'Ῥ' => 'ῥ', 'Ῡ' => 'ῡ', 'Ῑ' => 'ῑ',
        'Ῐ' => 'ῐ', 'ῌ' => 'ῃ', 'Ι' => 'ι', 'ᾼ' => 'ᾳ', 'Ᾱ' => 'ᾱ', 'Ᾰ' => 'ᾰ', 'ᾯ' => 'ᾧ', 'ᾮ' => 'ᾦ', 'ᾭ' => 'ᾥ', 'ᾬ' => 'ᾤ',
        'ᾫ' => 'ᾣ', 'ᾪ' => 'ᾢ', 'ᾩ' => 'ᾡ', 'ᾟ' => 'ᾗ', 'ᾞ' => 'ᾖ', 'ᾝ' => 'ᾕ', 'ᾜ' => 'ᾔ', 'ᾛ' => 'ᾓ', 'ᾚ' => 'ᾒ', 'ᾙ' => 'ᾑ',
        'ᾘ' => 'ᾐ', 'ᾏ' => 'ᾇ', 'ᾎ' => 'ᾆ', 'ᾍ' => 'ᾅ', 'ᾌ' => 'ᾄ', 'ᾋ' => 'ᾃ', 'ᾊ' => 'ᾂ', 'ᾉ' => 'ᾁ', 'ᾈ' => 'ᾀ', 'Ώ' => 'ώ',
        'Ὼ' => 'ὼ', 'Ύ' => 'ύ', 'Ὺ' => 'ὺ', 'Ό' => 'ό', 'Ὸ' => 'ὸ', 'Ί' => 'ί', 'Ὶ' => 'ὶ', 'Ή' => 'ή', 'Ὴ' => 'ὴ', 'Έ' => 'έ',
        'Ὲ' => 'ὲ', 'Ά' => 'ά', 'Ὰ' => 'ὰ', 'Ὧ' => 'ὧ', 'Ὦ' => 'ὦ', 'Ὥ' => 'ὥ', 'Ὤ' => 'ὤ', 'Ὣ' => 'ὣ', 'Ὢ' => 'ὢ', 'Ὡ' => 'ὡ',
        'Ὗ' => 'ὗ', 'Ὕ' => 'ὕ', 'Ὓ' => 'ὓ', 'Ὑ' => 'ὑ', 'Ὅ' => 'ὅ', 'Ὄ' => 'ὄ', 'Ὃ' => 'ὃ', 'Ὂ' => 'ὂ', 'Ὁ' => 'ὁ', 'Ὀ' => 'ὀ',
        'Ἷ' => 'ἷ', 'Ἶ' => 'ἶ', 'Ἵ' => 'ἵ', 'Ἴ' => 'ἴ', 'Ἳ' => 'ἳ', 'Ἲ' => 'ἲ', 'Ἱ' => 'ἱ', 'Ἰ' => 'ἰ', 'Ἧ' => 'ἧ', 'Ἦ' => 'ἦ',
        'Ἥ' => 'ἥ', 'Ἤ' => 'ἤ', 'Ἣ' => 'ἣ', 'Ἢ' => 'ἢ', 'Ἡ' => 'ἡ', 'Ἕ' => 'ἕ', 'Ἔ' => 'ἔ', 'Ἓ' => 'ἓ', 'Ἒ' => 'ἒ', 'Ἑ' => 'ἑ',
        'Ἐ' => 'ἐ', 'Ἇ' => 'ἇ', 'Ἆ' => 'ἆ', 'Ἅ' => 'ἅ', 'Ἄ' => 'ἄ', 'Ἃ' => 'ἃ', 'Ἂ' => 'ἂ', 'Ἁ' => 'ἁ', 'Ἀ' => 'ἀ', 'Ỹ' => 'ỹ',
        'Ỷ' => 'ỷ', 'Ỵ' => 'ỵ', 'Ỳ' => 'ỳ', 'Ự' => 'ự', 'Ữ' => 'ữ', 'Ử' => 'ử', 'Ừ' => 'ừ', 'Ứ' => 'ứ', 'Ủ' => 'ủ', 'Ụ' => 'ụ',
        'Ợ' => 'ợ', 'Ỡ' => 'ỡ', 'Ở' => 'ở', 'Ờ' => 'ờ', 'Ớ' => 'ớ', 'Ộ' => 'ộ', 'Ỗ' => 'ỗ', 'Ổ' => 'ổ', 'Ồ' => 'ồ', 'Ố' => 'ố',
        'Ỏ' => 'ỏ', 'Ọ' => 'ọ', 'Ị' => 'ị', 'Ỉ' => 'ỉ', 'Ệ' => 'ệ', 'Ễ' => 'ễ', 'Ể' => 'ể', 'Ề' => 'ề', 'Ế' => 'ế', 'Ẽ' => 'ẽ',
        'Ẻ' => 'ẻ', 'Ẹ' => 'ẹ', 'Ặ' => 'ặ', 'Ẵ' => 'ẵ', 'Ẳ' => 'ẳ', 'Ằ' => 'ằ', 'Ắ' => 'ắ', 'Ậ' => 'ậ', 'Ẫ' => 'ẫ', 'Ẩ' => 'ẩ',
        'Ầ' => 'ầ', 'Ấ' => 'ấ', 'Ả' => 'ả', 'Ạ' => 'ạ', 'Ṡ' => 'ẛ', 'Ẕ' => 'ẕ', 'Ẓ' => 'ẓ', 'Ẑ' => 'ẑ', 'Ẏ' => 'ẏ', 'Ẍ' => 'ẍ',
        'Ẋ' => 'ẋ', 'Ẉ' => 'ẉ', 'Ẇ' => 'ẇ', 'Ẅ' => 'ẅ', 'Ẃ' => 'ẃ', 'Ẁ' => 'ẁ', 'Ṿ' => 'ṿ', 'Ṽ' => 'ṽ', 'Ṻ' => 'ṻ', 'Ṹ' => 'ṹ',
        'Ṷ' => 'ṷ', 'Ṵ' => 'ṵ', 'Ṳ' => 'ṳ', 'Ṱ' => 'ṱ', 'Ṯ' => 'ṯ', 'Ṭ' => 'ṭ', 'Ṫ' => 'ṫ', 'Ṩ' => 'ṩ', 'Ṧ' => 'ṧ', 'Ṥ' => 'ṥ',
        'Ṣ' => 'ṣ', 'Ṡ' => 'ṡ', 'Ṟ' => 'ṟ', 'Ṝ' => 'ṝ', 'Ṛ' => 'ṛ', 'Ṙ' => 'ṙ', 'Ṗ' => 'ṗ', 'Ṕ' => 'ṕ', 'Ṓ' => 'ṓ', 'Ṑ' => 'ṑ',
        'Ṏ' => 'ṏ', 'Ṍ' => 'ṍ', 'Ṋ' => 'ṋ', 'Ṉ' => 'ṉ', 'Ṇ' => 'ṇ', 'Ṅ' => 'ṅ', 'Ṃ' => 'ṃ', 'Ṁ' => 'ṁ', 'Ḿ' => 'ḿ', 'Ḽ' => 'ḽ',
        'Ḻ' => 'ḻ', 'Ḹ' => 'ḹ', 'Ḷ' => 'ḷ', 'Ḵ' => 'ḵ', 'Ḳ' => 'ḳ', 'Ḱ' => 'ḱ', 'Ḯ' => 'ḯ', 'Ḭ' => 'ḭ', 'Ḫ' => 'ḫ', 'Ḩ' => 'ḩ',
        'Ḧ' => 'ḧ', 'Ḥ' => 'ḥ', 'Ḣ' => 'ḣ', 'Ḡ' => 'ḡ', 'Ḟ' => 'ḟ', 'Ḝ' => 'ḝ', 'Ḛ' => 'ḛ', 'Ḙ' => 'ḙ', 'Ḗ' => 'ḗ', 'Ḕ' => 'ḕ',
        'Ḓ' => 'ḓ', 'Ḑ' => 'ḑ', 'Ḏ' => 'ḏ', 'Ḍ' => 'ḍ', 'Ḋ' => 'ḋ', 'Ḉ' => 'ḉ', 'Ḇ' => 'ḇ', 'Ḅ' => 'ḅ', 'Ḃ' => 'ḃ', 'Ḁ' => 'ḁ',
        'Ֆ' => 'ֆ', 'Օ' => 'օ', 'Ք' => 'ք', 'Փ' => 'փ', 'Ւ' => 'ւ', 'Ց' => 'ց', 'Ր' => 'ր', 'Տ' => 'տ', 'Վ' => 'վ', 'Ս' => 'ս',
        'Ռ' => 'ռ', 'Ջ' => 'ջ', 'Պ' => 'պ', 'Չ' => 'չ', 'Ո' => 'ո', 'Շ' => 'շ', 'Ն' => 'ն', 'Յ' => 'յ', 'Մ' => 'մ', 'Ճ' => 'ճ',
        'Ղ' => 'ղ', 'Ձ' => 'ձ', 'Հ' => 'հ', 'Կ' => 'կ', 'Ծ' => 'ծ', 'Խ' => 'խ', 'Լ' => 'լ', 'Ի' => 'ի', 'Ժ' => 'ժ', 'Թ' => 'թ',
        'Ը' => 'ը', 'Է' => 'է', 'Զ' => 'զ', 'Ե' => 'ե', 'Դ' => 'դ', 'Գ' => 'գ', 'Բ' => 'բ', 'Ա' => 'ա', 'Ԏ' => 'ԏ', 'Ԍ' => 'ԍ',
        'Ԋ' => 'ԋ', 'Ԉ' => 'ԉ', 'Ԇ' => 'ԇ', 'Ԅ' => 'ԅ', 'Ԃ' => 'ԃ', 'Ԁ' => 'ԁ', 'Ӹ' => 'ӹ', 'Ӵ' => 'ӵ', 'Ӳ' => 'ӳ', 'Ӱ' => 'ӱ',
        'Ӯ' => 'ӯ', 'Ӭ' => 'ӭ', 'Ӫ' => 'ӫ', 'Ө' => 'ө', 'Ӧ' => 'ӧ', 'Ӥ' => 'ӥ', 'Ӣ' => 'ӣ', 'Ӡ' => 'ӡ', 'Ӟ' => 'ӟ', 'Ӝ' => 'ӝ',
        'Ӛ' => 'ӛ', 'Ә' => 'ә', 'Ӗ' => 'ӗ', 'Ӕ' => 'ӕ', 'Ӓ' => 'ӓ', 'Ӑ' => 'ӑ', 'Ӎ' => 'ӎ', 'Ӌ' => 'ӌ', 'Ӊ' => 'ӊ', 'Ӈ' => 'ӈ',
        'Ӆ' => 'ӆ', 'Ӄ' => 'ӄ', 'Ӂ' => 'ӂ', 'Ҿ' => 'ҿ', 'Ҽ' => 'ҽ', 'Һ' => 'һ', 'Ҹ' => 'ҹ', 'Ҷ' => 'ҷ', 'Ҵ' => 'ҵ', 'Ҳ' => 'ҳ',
        'Ұ' => 'ұ', 'Ү' => 'ү', 'Ҭ' => 'ҭ', 'Ҫ' => 'ҫ', 'Ҩ' => 'ҩ', 'Ҧ' => 'ҧ', 'Ҥ' => 'ҥ', 'Ң' => 'ң', 'Ҡ' => 'ҡ', 'Ҟ' => 'ҟ',
        'Ҝ' => 'ҝ', 'Қ' => 'қ', 'Ҙ' => 'ҙ', 'Җ' => 'җ', 'Ҕ' => 'ҕ', 'Ғ' => 'ғ', 'Ґ' => 'ґ', 'Ҏ' => 'ҏ', 'Ҍ' => 'ҍ', 'Ҋ' => 'ҋ',
        'Ҁ' => 'ҁ', 'Ѿ' => 'ѿ', 'Ѽ' => 'ѽ', 'Ѻ' => 'ѻ', 'Ѹ' => 'ѹ', 'Ѷ' => 'ѷ', 'Ѵ' => 'ѵ', 'Ѳ' => 'ѳ', 'Ѱ' => 'ѱ', 'Ѯ' => 'ѯ',
        'Ѭ' => 'ѭ', 'Ѫ' => 'ѫ', 'Ѩ' => 'ѩ', 'Ѧ' => 'ѧ', 'Ѥ' => 'ѥ', 'Ѣ' => 'ѣ', 'Ѡ' => 'ѡ', 'Џ' => 'џ', 'Ў' => 'ў', 'Ѝ' => 'ѝ',
        'Ќ' => 'ќ', 'Ћ' => 'ћ', 'Њ' => 'њ', 'Љ' => 'љ', 'Ј' => 'ј', 'Ї' => 'ї', 'І' => 'і', 'Ѕ' => 'ѕ', 'Є' => 'є', 'Ѓ' => 'ѓ',
        'Ђ' => 'ђ', 'Ё' => 'ё', 'Ѐ' => 'ѐ', 'Я' => 'я', 'Ю' => 'ю', 'Э' => 'э', 'Ь' => 'ь', 'Ы' => 'ы', 'Ъ' => 'ъ', 'Щ' => 'щ',
        'Ш' => 'ш', 'Ч' => 'ч', 'Ц' => 'ц', 'Х' => 'х', 'Ф' => 'ф', 'У' => 'у', 'Т' => 'т', 'С' => 'с', 'Р' => 'р', 'П' => 'п',
        'О' => 'о', 'Н' => 'н', 'М' => 'м', 'Л' => 'л', 'К' => 'к', 'Й' => 'й', 'И' => 'и', 'З' => 'з', 'Ж' => 'ж', 'Е' => 'е',
        'Д' => 'д', 'Г' => 'г', 'В' => 'в', 'Б' => 'б', 'А' => 'а', 'Ε' => 'ϵ', 'Σ' => 'ϲ', 'Ρ' => 'ϱ', 'Κ' => 'ϰ', 'Ϯ' => 'ϯ',
        'Ϭ' => 'ϭ', 'Ϫ' => 'ϫ', 'Ϩ' => 'ϩ', 'Ϧ' => 'ϧ', 'Ϥ' => 'ϥ', 'Ϣ' => 'ϣ', 'Ϡ' => 'ϡ', 'Ϟ' => 'ϟ', 'Ϝ' => 'ϝ', 'Ϛ' => 'ϛ',
        'Ϙ' => 'ϙ', 'Π' => 'ϖ', 'Φ' => 'ϕ', 'Θ' => 'ϑ', 'Β' => 'ϐ', 'Ώ' => 'ώ', 'Ύ' => 'ύ', 'Ό' => 'ό', 'Ϋ' => 'ϋ', 'Ϊ' => 'ϊ',
        'Ω' => 'ω', 'Ψ' => 'ψ', 'Χ' => 'χ', 'Φ' => 'φ', 'Υ' => 'υ', 'Τ' => 'τ', 'Σ' => 'σ', 'Σ' => 'ς', 'Ρ' => 'ρ', 'Π' => 'π',
        'Ο' => 'ο', 'Ξ' => 'ξ', 'Ν' => 'ν', 'Μ' => 'μ', 'Λ' => 'λ', 'Κ' => 'κ', 'Ι' => 'ι', 'Θ' => 'θ', 'Η' => 'η', 'Ζ' => 'ζ',
        'Ε' => 'ε', 'Δ' => 'δ', 'Γ' => 'γ', 'Β' => 'β', 'Α' => 'α', 'Ί' => 'ί', 'Ή' => 'ή', 'Έ' => 'έ', 'Ά' => 'ά', 'Ʒ' => 'ʒ',
        'Ʋ' => 'ʋ', 'Ʊ' => 'ʊ', 'Ʈ' => 'ʈ', 'Ʃ' => 'ʃ', 'Ʀ' => 'ʀ', 'Ɵ' => 'ɵ', 'Ɲ' => 'ɲ', 'Ɯ' => 'ɯ', 'Ɩ' => 'ɩ', 'Ɨ' => 'ɨ',
        'Ɣ' => 'ɣ', 'Ɛ' => 'ɛ', 'Ə' => 'ə', 'Ɗ' => 'ɗ', 'Ɖ' => 'ɖ', 'Ɔ' => 'ɔ', 'Ɓ' => 'ɓ', 'Ȳ' => 'ȳ', 'Ȱ' => 'ȱ', 'Ȯ' => 'ȯ',
        'Ȭ' => 'ȭ', 'Ȫ' => 'ȫ', 'Ȩ' => 'ȩ', 'Ȧ' => 'ȧ', 'Ȥ' => 'ȥ', 'Ȣ' => 'ȣ', 'Ȟ' => 'ȟ', 'Ȝ' => 'ȝ', 'Ț' => 'ț', 'Ș' => 'ș',
        'Ȗ' => 'ȗ', 'Ȕ' => 'ȕ', 'Ȓ' => 'ȓ', 'Ȑ' => 'ȑ', 'Ȏ' => 'ȏ', 'Ȍ' => 'ȍ', 'Ȋ' => 'ȋ', 'Ȉ' => 'ȉ', 'Ȇ' => 'ȇ', 'Ȅ' => 'ȅ',
        'Ȃ' => 'ȃ', 'Ȁ' => 'ȁ', 'Ǿ' => 'ǿ', 'Ǽ' => 'ǽ', 'Ǻ' => 'ǻ', 'Ǹ' => 'ǹ', 'Ǵ' => 'ǵ', 'ǲ' => 'ǳ', 'Ǯ' => 'ǯ', 'Ǭ' => 'ǭ',
        'Ǫ' => 'ǫ', 'Ǩ' => 'ǩ', 'Ǧ' => 'ǧ', 'Ǥ' => 'ǥ', 'Ǣ' => 'ǣ', 'Ǡ' => 'ǡ', 'Ǟ' => 'ǟ', 'Ǝ' => 'ǝ', 'Ǜ' => 'ǜ', 'Ǚ' => 'ǚ',
        'Ǘ' => 'ǘ', 'Ǖ' => 'ǖ', 'Ǔ' => 'ǔ', 'Ǒ' => 'ǒ', 'Ǐ' => 'ǐ', 'Ǎ' => 'ǎ', 'ǋ' => 'ǌ', 'ǈ' => 'ǉ', 'ǅ' => 'ǆ', 'Ƿ' => 'ƿ',
        'Ƽ' => 'ƽ', 'Ƹ' => 'ƹ', 'Ƶ' => 'ƶ', 'Ƴ' => 'ƴ', 'Ư' => 'ư', 'Ƭ' => 'ƭ', 'Ƨ' => 'ƨ', 'Ƥ' => 'ƥ', 'Ƣ' => 'ƣ', 'Ơ' => 'ơ',
        'Ƞ' => 'ƞ', 'Ƙ' => 'ƙ', 'Ƕ' => 'ƕ', 'Ƒ' => 'ƒ', 'Ƌ' => 'ƌ', 'Ƈ' => 'ƈ', 'Ƅ' => 'ƅ', 'Ƃ' => 'ƃ', 'S' => 'ſ', 'Ž' => 'ž',
        'Ż' => 'ż', 'Ź' => 'ź', 'Ŷ' => 'ŷ', 'Ŵ' => 'ŵ', 'Ų' => 'ų', 'Ű' => 'ű', 'Ů' => 'ů', 'Ŭ' => 'ŭ', 'Ū' => 'ū', 'Ũ' => 'ũ',
        'Ŧ' => 'ŧ', 'Ť' => 'ť', 'Ţ' => 'ţ', 'Š' => 'š', 'Ş' => 'ş', 'Ŝ' => 'ŝ', 'Ś' => 'ś', 'Ř' => 'ř', 'Ŗ' => 'ŗ', 'Ŕ' => 'ŕ',
        'Œ' => 'œ', 'Ő' => 'ő', 'Ŏ' => 'ŏ', 'Ō' => 'ō', 'Ŋ' => 'ŋ', 'Ň' => 'ň', 'Ņ' => 'ņ', 'Ń' => 'ń', 'Ł' => 'ł', 'Ŀ' => 'ŀ',
        'Ľ' => 'ľ', 'Ļ' => 'ļ', 'Ĺ' => 'ĺ', 'Ķ' => 'ķ', 'Ĵ' => 'ĵ', 'Ĳ' => 'ĳ', 'I' => 'ı', 'Į' => 'į', 'Ĭ' => 'ĭ', 'Ī' => 'ī',
        'Ĩ' => 'ĩ', 'Ħ' => 'ħ', 'Ĥ' => 'ĥ', 'Ģ' => 'ģ', 'Ġ' => 'ġ', 'Ğ' => 'ğ', 'Ĝ' => 'ĝ', 'Ě' => 'ě', 'Ę' => 'ę', 'Ė' => 'ė',
        'Ĕ' => 'ĕ', 'Ē' => 'ē', 'Đ' => 'đ', 'Ď' => 'ď', 'Č' => 'č', 'Ċ' => 'ċ', 'Ĉ' => 'ĉ', 'Ć' => 'ć', 'Ą' => 'ą', 'Ă' => 'ă',
        'Ā' => 'ā', 'Ÿ' => 'ÿ', 'Þ' => 'þ', 'Ý' => 'ý', 'Ü' => 'ü', 'Û' => 'û', 'Ú' => 'ú', 'Ù' => 'ù', 'Ø' => 'ø', 'Ö' => 'ö',
        'Õ' => 'õ', 'Ô' => 'ô', 'Ó' => 'ó', 'Ò' => 'ò', 'Ñ' => 'ñ', 'Ð' => 'ð', 'Ï' => 'ï', 'Î' => 'î', 'Í' => 'í', 'Ì' => 'ì',
        'Ë' => 'ë', 'Ê' => 'ê', 'É' => 'é', 'È' => 'è', 'Ç' => 'ç', 'Æ' => 'æ', 'Å' => 'å', 'Ä' => 'ä', 'Ã' => 'ã', 'Â' => 'â',
        'Á' => 'á', 'À' => 'à', 'Μ' => 'µ', 'Z' => 'z', 'Y' => 'y', 'X' => 'x', 'W' => 'w', 'V' => 'v', 'U' => 'u', 'T' => 't',
        'S' => 's', 'R' => 'r', 'Q' => 'q', 'P' => 'p', 'O' => 'o', 'N' => 'n', 'M' => 'm', 'L' => 'l', 'K' => 'k', 'J' => 'j',
        'I' => 'i', 'H' => 'h', 'G' => 'g', 'F' => 'f', 'E' => 'e', 'D' => 'd', 'C' => 'c', 'B' => 'b', 'A' => 'a'
    ],
    'romanize' => [
        // Lower accents
        'à' => 'a', 'ô' => 'o', 'ď' => 'd', 'ḟ' => 'f', 'ë' => 'e', 'š' => 's', 'ơ' => 'o', 'ß' => 'ss', 'ă' => 'a', 'ř' => 'r',
        'ț' => 't', 'ň' => 'n', 'ā' => 'a', 'ķ' => 'k', 'ŝ' => 's', 'ỳ' => 'y', 'ņ' => 'n', 'ĺ' => 'l', 'ħ' => 'h', 'ṗ' => 'p',
        'ó' => 'o', 'ú' => 'u', 'ě' => 'e', 'é' => 'e', 'ç' => 'c', 'ẁ' => 'w', 'ċ' => 'c', 'õ' => 'o', 'ṡ' => 's', 'ø' => 'o',
        'ģ' => 'g', 'ŧ' => 't', 'ș' => 's', 'ė' => 'e', 'ĉ' => 'c', 'ś' => 's', 'î' => 'i', 'ű' => 'u', 'ć' => 'c', 'ę' => 'e',
        'ŵ' => 'w', 'ṫ' => 't', 'ū' => 'u', 'č' => 'c', 'ö' => 'oe', 'è' => 'e', 'ŷ' => 'y', 'ą' => 'a', 'ł' => 'l', 'ų' => 'u',
        'ů' => 'u', 'ş' => 's', 'ğ' => 'g', 'ļ' => 'l', 'ƒ' => 'f', 'ž' => 'z', 'ẃ' => 'w', 'ḃ' => 'b', 'å' => 'a', 'ì' => 'i',
        'ï' => 'i', 'ḋ' => 'd', 'ť' => 't', 'ŗ' => 'r', 'ä' => 'ae', 'í' => 'i', 'ŕ' => 'r', 'ê' => 'e', 'ü' => 'ue', 'ò' => 'o',
        'ē' => 'e', 'ñ' => 'n', 'ń' => 'n', 'ĥ' => 'h', 'ĝ' => 'g', 'đ' => 'd', 'ĵ' => 'j', 'ÿ' => 'y', 'ũ' => 'u', 'ŭ' => 'u',
        'ư' => 'u', 'ţ' => 't', 'ý' => 'y', 'ő' => 'o', 'â' => 'a', 'ľ' => 'l', 'ẅ' => 'w', 'ż' => 'z', 'ī' => 'i', 'ã' => 'a',
        'ġ' => 'g', 'ṁ' => 'm', 'ō' => 'o', 'ĩ' => 'i', 'ù' => 'u', 'į' => 'i', 'ź' => 'z', 'á' => 'a', 'û' => 'u', 'þ' => 'th',
        'ð' => 'dh', 'æ' => 'ae', 'µ' => 'u', 'ĕ' => 'e', 'ạ' => 'a', 'ả' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ậ' => 'a', 'ẩ' => 'a',
        'ẫ' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ặ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ẻ' => 'e', 'ẹ' => 'e', 'ẽ' => 'e', 'ề' => 'e',
        'ế' => 'e', 'ệ' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ị' => 'i', 'ỉ' => 'i', 'ọ' => 'o', 'ỏ' => 'o', 'ờ' => 'o', 'ớ' => 'o',
        'ợ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ộ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ụ' => 'u', 'ủ' => 'u',
        'ừ' => 'u', 'ứ' => 'u', 'ự' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ỵ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y',
        // Upper accents
        'À' => 'A', 'Ô' => 'O', 'Ď' => 'D', 'Ḟ' => 'F', 'Ë' => 'E', 'Š' => 'S', 'Ơ' => 'O', 'Ă' => 'A', 'Ř' => 'R', 'Ț' => 'T',
        'Ň' => 'N', 'Ā' => 'A', 'Ķ' => 'K', 'Ŝ' => 'S', 'Ỳ' => 'Y', 'Ņ' => 'N', 'Ĺ' => 'L', 'Ħ' => 'H', 'Ṗ' => 'P', 'Ó' => 'O',
        'Ú' => 'U', 'Ě' => 'E', 'É' => 'E', 'Ç' => 'C', 'Ẁ' => 'W', 'Ċ' => 'C', 'Õ' => 'O', 'Ṡ' => 'S', 'Ø' => 'O', 'Ģ' => 'G',
        'Ŧ' => 'T', 'Ș' => 'S', 'Ė' => 'E', 'Ĉ' => 'C', 'Ś' => 'S', 'Î' => 'I', 'Ű' => 'U', 'Ć' => 'C', 'Ę' => 'E', 'Ŵ' => 'W',
        'Ṫ' => 'T', 'Ū' => 'U', 'Č' => 'C', 'Ö' => 'Oe', 'È' => 'E', 'Ŷ' => 'Y', 'Ą' => 'A', 'Ł' => 'L', 'Ų' => 'U', 'Ů' => 'U',
        'Ş' => 'S', 'Ğ' => 'G', 'Ļ' => 'L', 'Ƒ' => 'F', 'Ž' => 'Z', 'Ẃ' => 'W', 'Ḃ' => 'B', 'Å' => 'A', 'Ì' => 'I', 'Ï' => 'I',
        'Ḋ' => 'D', 'Ť' => 'T', 'Ŗ' => 'R', 'Ä' => 'Ae', 'Í' => 'I', 'Ŕ' => 'R', 'Ê' => 'E', 'Ü' => 'Ue', 'Ò' => 'O', 'Ē' => 'E',
        'Ñ' => 'N', 'Ń' => 'N', 'Ĥ' => 'H', 'Ĝ' => 'G', 'Đ' => 'D', 'Ĵ' => 'J', 'Ÿ' => 'Y', 'Ũ' => 'U', 'Ŭ' => 'U', 'Ư' => 'U',
        'Ţ' => 'T', 'Ý' => 'Y', 'Ő' => 'O', 'Â' => 'A', 'Ľ' => 'L', 'Ẅ' => 'W', 'Ż' => 'Z', 'Ī' => 'I', 'Ã' => 'A', 'Ġ' => 'G',
        'Ṁ' => 'M', 'Ō' => 'O', 'Ĩ' => 'I', 'Ù' => 'U', 'Į' => 'I', 'Ź' => 'Z', 'Á' => 'A', 'Û' => 'U', 'Þ' => 'Th', 'Ð' => 'Dh',
        'Æ' => 'Ae', 'Ĕ' => 'E', 'Ạ' => 'A', 'Ả' => 'A', 'Ầ' => 'A', 'Ấ' => 'A', 'Ậ' => 'A', 'Ẩ' => 'A', 'Ẫ' => 'A', 'Ằ' => 'A',
        'Ắ' => 'A', 'Ặ' => 'A', 'Ẳ' => 'A', 'Ẵ' => 'A', 'Ẻ' => 'E', 'Ẹ' => 'E', 'Ẽ' => 'E', 'Ề' => 'E', 'Ế' => 'E', 'Ệ' => 'E',
        'Ể' => 'E', 'Ễ' => 'E', 'Ị' => 'I', 'Ỉ' => 'I', 'Ọ' => 'O', 'Ỏ' => 'O', 'Ờ' => 'O', 'Ớ' => 'O', 'Ợ' => 'O', 'Ở' => 'O',
        'Ỡ' => 'O', 'Ồ' => 'O', 'Ố' => 'O', 'Ộ' => 'O', 'Ổ' => 'O', 'Ỗ' => 'O', 'Ụ' => 'U', 'Ủ' => 'U', 'Ừ' => 'U', 'Ứ' => 'U',
        'Ự' => 'U', 'Ử' => 'U', 'Ữ' => 'U', 'Ỵ' => 'Y', 'Ỷ' => 'Y', 'Ỹ' => 'Y',
        // Other
        'ǐ' => 'i', 'ǔ' => 'u', 'ǎ' => 'a', 'ǒ' => 'o', 'ǚ' => 'u', 'ǚ' => 'u', 'ǜ' => 'u', 'ǐ' => 'i', 'ǐ' => 'i', '@' => 'a'
    ]
];
// @formatter:on
