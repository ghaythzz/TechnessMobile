/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.components.SpanLabel;
import com.codename1.l10n.ParseException;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycomany.entities.Ordonnance;
import com.mycomany.entities.Reservation;
import com.mycompany.myapp.services.ServiceOrdonnance;
import com.mycompany.myapp.services.ServiceReservation;
import java.util.ArrayList;


/**
 *
 * @author nassi
 */
public class ListReservationForm extends Form {
    public ListReservationForm(Form previous){
     
        setTitle("Liste des reservations");
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
        ServiceOrdonnance es = new ServiceOrdonnance();
try{
        ArrayList<Reservation> list = es.getAllReservation();
         {
           
            for (Reservation o : list) {

          
 
                Container c3 = new Container(BoxLayout.y());
               
                 SpanLabel cat= new SpanLabel("date de reservation :" + o.getStart());
                 
                 
               
                     
                      
                        c3.add(cat);
                        
                        
                        Button update =new Button("Ajouter Ordonnance");
                       
                        c3.add(update);
                
                        update.addActionListener(e -> new addOrdonnanceForm(this,o.getId()).show());
                    
                
                        
                        add(c3);
              
            
                }
            
          getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
                
            }
         } catch (ParseException e) {
    e.printStackTrace();}
         
    }
}
