import {Headers, RequestOptions, Response} from "@angular/http";
import {Observable} from "rxjs";

export const apiPrefix = 'http://blog.loc';
export const pageTitle = 'Maria';

export class CommonUtil {

    static extractData(res: Response, defaultValue: any = {}) {
        let body = res.json();
        return body || defaultValue;
    }

    static handleError(error: Response) {
        // in a real world app, we may send the server to some remote logging infrastructure
        // instead of just logging it to the console
        console.error(error);
        // return Observable.throw(error.json().error || 'Server error');
        return Observable.throw(error || 'Server error');
    }

    static getContentTypeUrlEncoded(): RequestOptions {
        let headers = new Headers({
            'Content-Type': 'application/x-www-form-urlencoded',
        });
        return new RequestOptions({headers: headers});
    }

    static getContentTypeJson(): RequestOptions {
        let headers = new Headers({
            'Content-Type': 'application/json',
        });
        return new RequestOptions({headers: headers});
    }

    static transliterateUrl(str) {
        str = str.toLowerCase();
        let newStr: string = "";

        let cyr2latChars = [
            ['а', 'a'], ['б', 'b'], ['в', 'v'], ['г', 'g'],
            ['д', 'd'], ['е', 'e'], ['ё', 'yo'], ['ж', 'zh'], ['з', 'z'],
            ['и', 'i'], ['й', 'y'], ['к', 'k'], ['л', 'l'],
            ['м', 'm'], ['н', 'n'], ['о', 'o'], ['п', 'p'], ['р', 'r'],
            ['с', 's'], ['т', 't'], ['у', 'u'], ['ф', 'f'],
            ['х', 'h'], ['ц', 'c'], ['ч', 'ch'], ['ш', 'sh'], ['щ', 'shch'],
            ['ъ', ''], ['ы', 'y'], ['ь', ''], ['э', 'e'], ['ю', 'yu'], ['я', 'ya'],
            ['А', 'A'], ['Б', 'B'], ['В', 'V'], ['Г', 'G'],
            ['Д', 'D'], ['Е', 'E'], ['Ё', 'YO'], ['Ж', 'ZH'], ['З', 'Z'],
            ['И', 'I'], ['Й', 'Y'], ['К', 'K'], ['Л', 'L'],
            ['М', 'M'], ['Н', 'N'], ['О', 'O'], ['П', 'P'], ['Р', 'R'],
            ['С', 'S'], ['Т', 'T'], ['У', 'U'], ['Ф', 'F'],
            ['Х', 'H'], ['Ц', 'C'], ['Ч', 'CH'], ['Ш', 'SH'], ['Щ', 'SHCH'],
            ['Ъ', ''], ['Ы', 'Y'], ['Ь', ''], ['Э', 'E'],
            ['Ю', 'YU'], ['Я', 'YA'],
            ['a', 'a'], ['b', 'b'], ['c', 'c'], ['d', 'd'], ['e', 'e'],
            ['f', 'f'], ['g', 'g'], ['h', 'h'], ['i', 'i'], ['j', 'j'],
            ['k', 'k'], ['l', 'l'], ['m', 'm'], ['n', 'n'], ['o', 'o'],
            ['p', 'p'], ['q', 'q'], ['r', 'r'], ['s', 's'], ['t', 't'],
            ['u', 'u'], ['v', 'v'], ['w', 'w'], ['x', 'x'], ['y', 'y'],
            ['z', 'z'],
            ['A', 'A'], ['B', 'B'], ['C', 'C'], ['D', 'D'], ['E', 'E'],
            ['F', 'F'], ['G', 'G'], ['H', 'H'], ['I', 'I'], ['J', 'J'], ['K', 'K'],
            ['L', 'L'], ['M', 'M'], ['N', 'N'], ['O', 'O'], ['P', 'P'],
            ['Q', 'Q'], ['R', 'R'], ['S', 'S'], ['T', 'T'], ['U', 'U'], ['V', 'V'],
            ['W', 'W'], ['X', 'X'], ['Y', 'Y'], ['Z', 'Z'],
            [' ', '_'], ['0', '0'], ['1', '1'], ['2', '2'], ['3', '3'],
            ['4', '4'], ['5', '5'], ['6', '6'], ['7', '7'], ['8', '8'], ['9', '9'],
            ['-', '-']];


        for (var i = 0; i < str.length; i++) {
            let ch = str.charAt(i);
            let newCh = '';
            for (var j = 0; j < cyr2latChars.length; j++) {
                if (ch == cyr2latChars[j][0]) {
                    newCh = cyr2latChars[j][1];
                }
            }
            newStr += newCh;
        }

        return newStr.replace(/[_]{2,}/gim, '_').replace(/\n/gim, '');
    }

}