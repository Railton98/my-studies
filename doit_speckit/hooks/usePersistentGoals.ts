/**
 * Custom hook for persistent goal storage
 * Handles reading goals from localStorage on mount and hydration safety
 */

"use client";

import { loadGoals } from "@/lib/storage";
import { Goal } from "@/types/goal";
import { useEffect, useState } from "react";

/**
 * Hook to load goals from localStorage with hydration safety
 * Ensures window is defined before accessing localStorage
 * @returns Object with goals array and loading state
 */
export function usePersistentGoals(): { goals: Goal[]; isLoading: boolean } {
  const [state, setState] = useState<{ goals: Goal[]; hydrated: boolean }>({
    goals: [],
    hydrated: false,
  });

  useEffect(() => {
    // Load goals from localStorage on mount
    if (typeof window !== "undefined") {
      const loadedGoals = loadGoals();
      setState({ goals: loadedGoals, hydrated: true });
    }
  }, []);

  return { goals: state.goals, isLoading: !state.hydrated };
}
