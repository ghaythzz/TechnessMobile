/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.components.SpanLabel;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycomany.entities.Medicament;
import com.mycomany.entities.Ordonnance;
import com.mycompany.myapp.services.ServiceMedicament;
import com.mycompany.myapp.services.ServiceOrdonnance;
import java.util.ArrayList;

/**
 *
 * @author nassi
 */
public class ListMedicamentForm extends Form{
    public ListMedicamentForm(Form previous){
     
        setTitle("Shop");
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
        ServiceMedicament es = new ServiceMedicament();

        ArrayList<Medicament> list = es.getAllMedicament();
         {
           
            for (Medicament o : list) {

          
 
                Container c3 = new Container(BoxLayout.y());
               
                 SpanLabel cat= new SpanLabel("Nom de Medicament :" + o.getNom());
                 SpanLabel cat1= new SpanLabel("Type de Medicament :" + o.getType());
                 SpanLabel cat2= new SpanLabel("Nombre des Doses :" + o.getNb_dose());
                 SpanLabel cat3= new SpanLabel("Prix :" + o.getPrix());
                 SpanLabel cat4= new SpanLabel("Stock :" + o.getStock());
                 SpanLabel cat5= new SpanLabel("------------------------");
                 
               
                     
                      
                        c3.add(cat);
                        c3.add(cat1);
                        c3.add(cat2);
                        c3.add(cat3);
                        c3.add(cat4);
                        c3.add(cat5);
                
                        
                        add(c3);
              
            
          getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
                
            }
         }
    }
}
