import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'autoEstado'
})
export class AutoEstadoPipe implements PipeTransform {

  transform(estado: any, args?: any): any {

    let retorno: string = "";

  /*  if (estado < 10000)
      retorno = "Primer Service";
    else
      if (estado > 10000 && estado < 25000)
        retorno = "Segundo Service";
      else
        retorno = "Usado";*/

         if (estado < 10000)
         {
           retorno = "Primer Service";
         }
         if (estado < 10000 && estado < 25000)
         {
           retorno = "Segundo Service";
         }
         if (estado > 45000 && estado < 55000)
         {
           retorno = "Service Media Vida";
         }
         if (estado < 55000 && estado < 100000)
         {
           retorno = "Ultimo Service Garantia";
         }
         if (estado > 100000)
         {
           retorno = "Service Regular";
         }
    

    return retorno;
  }

}
