import BusinessSection from '../components/home/BusinessSection.jsx';
import FaqSection from '../components/home/FaqSection.jsx';
import FeatureSection from '../components/home/FeatureSection.jsx';
import HomeFooter from '../components/home/HomeFooter.jsx';
import HeroSection from '../components/home/HeroSection.jsx';
import HomeNavbar from '../components/home/HomeNavbar.jsx';
import StatsSection from '../components/home/StatsSection.jsx';
import TestimonialsSection from '../components/home/TestimonialsSection.jsx';

export default function HomePage() {
  return (
    <div className="min-h-screen bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100">
      <HomeNavbar />
      <HeroSection />
      <FeatureSection />
      <StatsSection />
      <TestimonialsSection />
      <BusinessSection />
      <FaqSection />
      <HomeFooter />
    </div>
  );
}
