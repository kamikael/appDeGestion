import { Routes } from '@angular/router';
import { AboutComponent } from './about/about.component';
import { ContactComponent } from './contact/contact.component';
import {HomeComponent } from './home/home.component';
import { DetailArticleComponent } from './detail-article/detail-article.component';
import { MyaccountComponent } from './myaccount/myaccount.component';
import { AllcoursesComponent } from './allcourses/allcourses.component';
import { CourseDetailComponent } from './courses/course-detail.component';

export const routes: Routes = [
  { path: '', component:HomeComponent }, // pour la page d'accueil
  { path: 'allcourses', component: AllcoursesComponent},
  { path: 'about', component: AboutComponent },
  { path: 'contact', component: ContactComponent },
  { path: 'myaccount', component: MyaccountComponent},
  { path: 'detail-article/:category', component: DetailArticleComponent }, // route pour le détail d'article
  { path: 'courses/:id', component: CourseDetailComponent },
  { path: 'myaccount', component: MyaccountComponent },
];
